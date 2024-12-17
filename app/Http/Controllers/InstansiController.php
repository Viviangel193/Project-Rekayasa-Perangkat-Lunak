<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use App\Pengguna;
use App\Mahasiswa;

class InstansiController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('Login.login');
    }

    // Menangani proses login
    public function login(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required',
            'kata_sandi' => 'required',
        ]);

        // Ambil pengguna berdasarkan nama pengguna
        $user = Pengguna::where('nama_pengguna', $request->nama_pengguna)->first();

        // Cek apakah pengguna ada dan passwordnya cocok
        if ($user && $user->kata_sandi === $request->kata_sandi) {
            // Login berhasil
            Auth::login($user); // Login pengguna
            // Redirect berdasarkan peran user
            if ($user->peran === 'admin') {
                return redirect()->route('instansi.home');
            } elseif ($user->peran === 'mahasiswa') {
                return redirect()->route('maha.profil');
            }
        } else {
            // Login gagal
            return back()->with('error', 'Username atau password salah');
        }
    }

    // Menangani logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Dashboard Home
    public function home()
    {
        $client = new Client();
        $url = 'https://termite-huge-mastodon.ngrok-free.app/api/tagihan';

        try {
            // Panggil API untuk mendapatkan data tagihan
            $response = $client->get($url);
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            // Pastikan data ada di dalam 'data' -> 'data'
            $transactions = $data['data']['data'] ?? [];

            // Hitung jumlah mahasiswa berdasarkan status pembayaran
            $sudahMembayar = 0;
            $belumMembayar = 0;

            foreach ($transactions as $transaction) {
                if ($transaction['status_transaksi'] === 'Sudah Bayar') {
                    $sudahMembayar++;
                } elseif ($transaction['status_transaksi'] === 'Menunggu Pembayaran') {
                    $belumMembayar++;
                }
            }

            // Hitung total mahasiswa dari database
            $totalMahasiswa = Mahasiswa::count();
            $totalLakiLaki = Mahasiswa::where('jenis_kelamin', 'Laki-laki')->count();
            $totalPerempuan = Mahasiswa::where('jenis_kelamin', 'Perempuan')->count();

            // Kirim data ke view
            return view('Instansi.home', compact('totalMahasiswa', 'totalLakiLaki', 'totalPerempuan', 'sudahMembayar', 'belumMembayar'));
        } catch (\Exception $e) {
            \Log::error('Error fetching data: ' . $e->getMessage());
            return view('Instansi.home', [
                'totalMahasiswa' => 0,
                'totalLakiLaki' => 0,
                'totalPerempuan' => 0,
                'sudahMembayar' => 0,
                'belumMembayar' => 0,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function dataTrx()
    {
        $client = new Client();
        $url = 'https://termite-huge-mastodon.ngrok-free.app/api/tagihan';

        try {
            // Panggil API untuk mendapatkan data tagihan
            $response = $client->get($url);
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            // Pastikan data ada di dalam 'data' -> 'data'
            $transactions = $data['data']['data'] ?? [];

            // Ambil semua NIM mahasiswa dari database
            $mahasiswaData = Mahasiswa::pluck('nama_lengkap', 'nim')->toArray();

            // Gabungkan data transaksi dengan data mahasiswa berdasarkan NIM
            foreach ($transactions as &$transaction) {
                $nim = $transaction['id_mahasiswa'];
                $transaction['nama_mahasiswa'] = $mahasiswaData[$nim] ?? 'Tidak Diketahui';
            }

            // Logika Pencarian
            $search = request()->query('search');
            if ($search) {
                $transactions = array_filter($transactions, function ($transaction) use ($search) {
                    return str_contains(strtolower($transaction['id_mahasiswa']), strtolower($search)) ||
                        str_contains(strtolower($transaction['nama_mahasiswa']), strtolower($search)) ||
                        str_contains(strtolower($transaction['status_transaksi']), strtolower($search));
                });
            }

            return view('Instansi.dataTrx', [
                'transactions' => $transactions,
                'search' => $search, // Kirim kata kunci pencarian ke view
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching data: ' . $e->getMessage());
            return view('Instansi.dataTrx', ['transactions' => [], 'error' => $e->getMessage()]);
        }
    }


    // VA Pembayaran
    public function vaPembayaran()
    {
        return view('Instansi.va_byr');
    }

    // Manajemen Pembayaran
    public function manajemenPembayaran()
    {
        $client = new Client();
        $url = 'https://termite-huge-mastodon.ngrok-free.app/api/manajemenpembayaran';

        try {
            $response = $client->get($url);
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            // Pastikan mengambil data yang benar dari `data['data']`
            $items = $data['data']['data'] ?? []; // Ambil array dari `data.data`

            return view('Instansi.man_pem', ['data' => $items]);
        } catch (\Exception $e) {
            return view('Instansi.man_pem', ['data' => [], 'error' => $e->getMessage()]);
        }
    }

    // Manajemen Pembayaran
    public function mP1()
    {
        return view('Instansi.man_pem1');
    }

    // Manajemen Pembayaran
    public function mP2()
    {
        return view('Instansi.man_pem2');
    }


    // Tambah Data Mahasiswa
    public function tambahDataMahasiswa()
    {
        return view('Instansi.mhs');
    }

    public function tambahMhs()
    {
        return view('Instansi.tmbh_mhs');
    }

    // Report Tagihan
    public function reportTagihan()
    {
        return view('Instansi.report');
    }

    // public function byr()
    // {
    //     return view('Instansi.tmbh_byr');
    // }

    public function databyr()
    {
        return view('Instansi.databyr');
    }

    public function cetak($id_tagihan)
    {
        try {
            $client = new Client();
            $url = "https://termite-huge-mastodon.ngrok-free.app/api/tagihan/{$id_tagihan}";

            // Ambil data tagihan dari API
            $response = $client->get($url);
            $data = json_decode($response->getBody()->getContents(), true);

            if (!isset($data['data'])) {
                throw new \Exception('Data tagihan tidak ditemukan.');
            }

            $tagihan = $data['data'];

            // Ambil id_mahasiswa dari data tagihan
            $id_mahasiswa = $tagihan['id_mahasiswa'];

            // Cari data mahasiswa di database berdasarkan NIM
            $mahasiswa = Mahasiswa::where('nim', $id_mahasiswa)->first();
            if (!$mahasiswa) {
                throw new \Exception('Data mahasiswa tidak ditemukan di database.');
            }

            // Siapkan data untuk invoice
            $invoiceData = [
                'kategori_pembayaran' => $tagihan['deskripsi'] ?? 'Tidak Diketahui',
                'nomor_pembayaran' => $tagihan['no_va'] ?? 'Tidak Diketahui',
                'nama_mahasiswa' => $mahasiswa->nama_lengkap,
                'nim' => $mahasiswa->nim,
                'program_studi' => $mahasiswa->jurusan,
                'periode' => $tagihan['periode'] ?? 'Tidak Diketahui',
                'tagihan' => $tagihan['jmlh_tgh'] ?? 0,
                'sks' => $tagihan['sks'] ?? 0,
                'biaya_kesehatan' => $tagihan['detail_tagihan']['biaya_kesehatan'] ?? 0,
                'biaya_gedung' => $tagihan['detail_tagihan']['biaya_gedung'] ?? 0,
                'potongan_prestasi' => $tagihan['detail_tagihan']['potongan_prestasi'] ?? 0,
                'denda' => $tagihan['detail_tagihan']['hrg_denda'] ?? 0,
                'total_bayar' => $tagihan['jmlh_tgh'] ?? 0,
            ];

            return view('Instansi.invoice', compact('invoiceData'));
        } catch (\Exception $e) {
            \Log::error('Error fetching invoice data: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    // public function getVA()
    // {
    //     $url = env('BANKPAYMENTWEB_URL') . '/va';
    //     $token = env('BANKPAYMENTWEB_TOKEN');

    //     $response = Http::withHeaders([
    //         'Authorization' => $token, // Token dikirim di header
    //     ])->get($url);

    //     if ($response->successful()) {
    //         return $response->json();
    //     } else {
    //         return response()->json(['error' => 'Failed to fetch data'], $response->status());
    //     }
    // }
}
