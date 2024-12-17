<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Mahasiswa;
use App\Pembayaran;

class MhsController extends Controller
{
    // Menampilkan profil mahasiswa
    public function profil()
    {
        // Ambil pengguna yang sedang login
        $pengguna = Auth::user(); // Pastikan pengguna sudah terautentikasi

        // Ambil data mahasiswa berdasarkan NIM pengguna
        $mahasiswa = Mahasiswa::where('nim', $pengguna->nama_pengguna)->first();

        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        return view('maha.profil', compact('mahasiswa'));
    }

    public function bayar(Request $request)
    {
        $client = new Client();

        try {
            // Dapatkan data pengguna yang sedang login
            $pengguna = Auth::user();
            $namaPengguna = $pengguna->nama_pengguna;

            if (!$namaPengguna) {
                throw new \Exception('Nama pengguna tidak ditemukan.');
            }

            // Cari mahasiswa berdasarkan nim yang sama dengan nama_pengguna
            $mahasiswa = Mahasiswa::where('nim', $namaPengguna)->first();

            if (!$mahasiswa) {
                throw new \Exception('Data mahasiswa tidak ditemukan.');
            }

            $nim = $mahasiswa->nim;

            // Kirim request GET ke API dengan filter berdasarkan NIM
            $response = $client->request('GET', "https://termite-huge-mastodon.ngrok-free.app/api/va?id_mahasiswa={$nim}");

            // Decode data dari API
            $data = json_decode($response->getBody(), true);

            // Validasi struktur data API
            if (empty($data['data']['data'])) {
                throw new \Exception('Data tagihan tidak ditemukan.');
            }

            // Ambil tagihan pertama
            $tagihan = $data['data']['data'][0];
            $detailTagihan = $tagihan['tagihan'];

            // Pastikan kunci 'id_tagihan' ada di detail tagihan
            if (!isset($detailTagihan['id_tagihan'])) {
                throw new \Exception('ID tagihan tidak ditemukan dalam data.');
            }

            $jumlahTagihan = (float) $detailTagihan['jmlh_tgh'] ?? 0;
            $statusTransaksi = $detailTagihan['status_transaksi'] ?? 'Menunggu Pembayaran';

            $message = null;

            // Cek status transaksi
            if ($statusTransaksi === 'Sudah Bayar') {
                $message = 'Tagihan sudah dibayar.';
            } elseif ($mahasiswa->saldo < $jumlahTagihan) {
                $message = 'Saldo tidak cukup untuk membayar tagihan.';
            } else {
                // Proses pembayaran
                DB::transaction(function () use ($mahasiswa, $jumlahTagihan, $detailTagihan) {
                    // Kurangi saldo mahasiswa
                    $mahasiswa->saldo -= $jumlahTagihan;
                    $mahasiswa->save();

                    // Pastikan kolom id_tagihan ada dalam tabel pembayaran
                    if (Schema::hasColumn('pembayaran', 'id_tagihan')) {
                        // Update status transaksi di tabel pembayaran
                        Pembayaran::where('mahasiswa_id', $mahasiswa->id)
                            ->where('id_tagihan', $detailTagihan['id_tagihan'])
                            ->update(['status_transaksi' => 'Sudah Dibayar']);
                    } else {
                        throw new \Exception('Kolom id_tagihan tidak ditemukan di tabel pembayaran.');
                    }
                });

                $message = 'Pembayaran berhasil dilakukan.';
            }

            // Kirim data ke view dengan pesan
            return view('maha.bayar', [
                'tagihanList' => $data['data']['data'],
                'virtualAccount' => $tagihan['no_va'] ?? 'Tidak tersedia',
                'success' => $message,
            ]);

        } catch (\Exception $e) {
            // Tangani error dan kirim pesan error ke view
            Log::error('Error in bayar method: ' . $e->getMessage());

            return view('maha.bayar', [
                'tagihanList' => null,
                'virtualAccount' => null,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function showMahasiswa(Request $request)
    {
        $query = Mahasiswa::query();

        // Search by a generic 'search' parameter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($query) use ($searchTerm) {
                $query->where('nim', 'like', '%' . $searchTerm . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $searchTerm . '%')
                    ->orWhere('angkatan', 'like', '%' . $searchTerm . '%')
                    ->orWhere('jurusan', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by gender
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Fetch results and apply pagination
        $mahasiswas = $query->paginate(10);

        return view('Instansi.mhs', compact('mahasiswas'));
    }

    // Menampilkan form tambah mahasiswa
    public function tambahMahasiswaForm()
    {
        return view('Instansi.tmbh_mhs');
    }

    // Menyimpan data mahasiswa
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nim' => 'required|unique:mahasiswas|size:8', // Validasi panjang NIM 8 karakter
            'nama_lengkap' => 'required',
            'angkatan' => 'required',
            'jurusan' => 'required',
            'gender' => 'required',
        ]);

        // Simpan data mahasiswa
        Mahasiswa::create([
            'nim' => $request->nim,
            'nama_lengkap' => $request->nama_lengkap,
            'angkatan' => $request->angkatan,
            'jurusan' => $request->jurusan,
            'jenis_kelamin' => $request->gender,
            'saldo' => 10000000, // Set saldo default menjadi 10.000.000
        ]);

        // Redirect ke halaman mahasiswa dengan pesan sukses
        return redirect()->route('instansi.mhs')->with('success', 'Data mahasiswa berhasil ditambahkan!');
    }


    // Menghapus data mahasiswa
    public function delete($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        return redirect()->route('instansi.mhs')->with('success', 'Data mahasiswa berhasil dihapus!');
    }

    // Menampilkan form edit mahasiswa
    public function editMahasiswaForm($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('Instansi.edit_mhs', compact('mahasiswa'));
    }

    // Memperbarui data mahasiswa
    public function updateMahasiswa(Request $request, $id)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim,' . $id . '|size:8', // Validasi panjang NIM 8 karakter
            'nama_lengkap' => 'required',
            'angkatan' => 'required',
            'jurusan' => 'required',
            'gender' => 'required',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update([
            'nim' => $request->nim,
            'nama_lengkap' => $request->nama_lengkap,
            'angkatan' => $request->angkatan,
            'jurusan' => $request->jurusan,
            'jenis_kelamin' => $request->gender,
        ]);

        return redirect()->route('instansi.mhs')->with('success', 'Data mahasiswa berhasil diperbarui!');
    }

    public function saldo()
    {
        // Ambil pengguna yang sedang login
        $pengguna = Auth::user();

        // Ambil saldo mahasiswa berdasarkan nama_pengguna (diasumsikan nama_pengguna = nim)
        $saldo = DB::table('mahasiswas')
            ->where('nim', $pengguna->nama_pengguna)
            ->value('saldo');

        // Jika saldo tidak ditemukan, tampilkan pesan error
        if (is_null($saldo)) {
            return redirect()->route('maha.saldo')->with('error', 'Saldo tidak ditemukan untuk pengguna ini.');
        }

        // Kirimkan saldo ke view
        return view('maha.saldo', compact('saldo'));
    }

    public function updateSaldo(Mahasiswa $mahasiswa)
    {
        $totalTagihan = $mahasiswa->pembayaran->where('tipe', 'tagihan')->sum('jumlah');
        $totalPembayaran = $mahasiswa->pembayaran->where('tipe', 'pembayaran')->sum('jumlah');

        $mahasiswa->saldo = $totalTagihan - $totalPembayaran;
        $mahasiswa->save();
    }

    public function pb()
    {
        return view('maha.pembyr');
    }

    public function detail(Request $request)
    {
        // Validasi input nomor VA
        $request->validate([
            'no_va' => 'required|numeric|min:1', // Pastikan no_va valid
        ]);

        $noVA = $request->input('no_va');

        try {
            // Buat instance Guzzle Client untuk komunikasi API
            $client = new Client();

            // Kirim permintaan GET ke API untuk mengambil data VA berdasarkan nomor VA
            $response = $client->request('GET', "https://termite-huge-mastodon.ngrok-free.app/api/va/{$noVA}");

            // Dapatkan status code dan log response untuk debugging
            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();
            Log::info('API Status Code: ' . $statusCode);
            Log::info('API Response: ' . $responseBody);

            // Periksa apakah status code adalah 200 (OK)
            if ($statusCode != 200) {
                return redirect()->route('maha.pb')->with('error', 'Terjadi kesalahan pada API. Status Code: ' . $statusCode . '. Coba lagi nanti.');
            }

            // Decode response JSON
            $data = json_decode($responseBody, true);

            // Pastikan data 'data' dan 'tagihan' ada di dalam response
            if (empty($data['data']) || empty($data['data']['tagihan'])) {
                return redirect()->route('maha.pb')->with('error', 'Nomor Virtual Account tidak ditemukan atau data tidak lengkap.');
            }

            // Ambil data tagihan dari response
            $detail = $data['data']['tagihan'];

            // Ambil data mahasiswa berdasarkan nim
            $mahasiswa = Mahasiswa::where('nim', $detail['id_mahasiswa'])->first();

            // Periksa apakah data mahasiswa ditemukan
            if (!$mahasiswa) {
                return redirect()->route('maha.pb')->with('error', 'Data mahasiswa tidak ditemukan.');
            }

            // Tentukan nilai ICE dan potongan prestasi
            $ice = $detail['ice'] === 'Tidak' ? 0 : 100000; // jika 'Tidak' maka Rp. 0, jika 'Iya' Rp. 100000
            $potonganPrestasi = $detail['potongan_prestasi'] === 'Iya' ? 120000 : 0; // jika 'Iya' maka Rp. 120000, jika 'Tidak' Rp. 0

            // Kirim data ke view
            return view('maha.detail', compact('detail', 'mahasiswa', 'ice', 'potonganPrestasi'));

        } catch (\Exception $e) {
            // Tangani error dan log kesalahan secara rinci
            Log::error('Error during API request: ' . $e->getMessage());
            return redirect()->route('maha.pb')->with('error', 'Terjadi kesalahan saat mengambil data. Kami tidak dapat terhubung ke server. Pastikan koneksi internet Anda stabil dan coba lagi nanti.');
        }
    }

    public function trx()
    {
        $client = new Client();

        try {
            $pengguna = Auth::user();
            $id_mahasiswa = $pengguna->nama_pengguna;

            if (!$id_mahasiswa) {
                throw new \Exception('NIM pengguna tidak ditemukan.');
            }

            // Ambil data mahasiswa
            $mahasiswa = Mahasiswa::where('nim', $id_mahasiswa)->first();

            if (!$mahasiswa) {
                throw new \Exception('Data mahasiswa tidak ditemukan.');
            }

            // Kirim permintaan GET ke API untuk mengambil data tagihan
            $response = $client->request('GET', "https://termite-huge-mastodon.ngrok-free.app/api/va?id_mahasiswa={$id_mahasiswa}");
            $data = json_decode($response->getBody(), true);

            // Cek apakah data tagihan tersedia
            if (empty($data['data']['data']) || empty($data['data']['data'][0])) {
                throw new \Exception('Data tagihan tidak ditemukan.');
            }

            // Ambil detail tagihan pertama
            $detail = $data['data']['data'][0]['tagihan'];
            $mahasiswaDetail = $data['data']['data'][0]['mahasiswa'];

            // Tentukan nilai ICE dan potongan prestasi berdasarkan kondisi
            $ice = $detail['ice'] === 'Tidak' ? 0 : 100000;
            $potonganPrestasi = $detail['potongan_prestasi'] === 'Iya' ? 120000 : 0;

            // Kirimkan data ke view
            return view('maha.trx', compact('mahasiswa', 'detail', 'mahasiswaDetail', 'ice', 'potonganPrestasi'));

        } catch (\Exception $e) {
            // Tangani error dan kirimkan pesan error ke view
            return view('maha.trx', [
                'error' => $e->getMessage(),
                'mahasiswa' => null,
                'detail' => [
                    'sks' => 0,
                    'no_va' => 'Tidak tersedia',
                    'periode' => 'Tidak Tersedia',
                    'denda' => 'Tidak',
                ],
                'ice' => 0,
                'potonganPrestasi' => 0,
            ]);
        }
    }

    public function rw()
    {
        $client = new Client();

        try {
            // Ambil pengguna yang sedang login
            $pengguna = Auth::user();
            $id_mahasiswa = $pengguna->nama_pengguna;

            if (!$id_mahasiswa) {
                throw new \Exception('NIM pengguna tidak ditemukan.');
            }

            // Kirim permintaan GET ke API untuk mengambil data transaksi
            $response = $client->request('GET', "https://termite-huge-mastodon.ngrok-free.app/api/va?id_mahasiswa={$id_mahasiswa}");
            $data = json_decode($response->getBody(), true);

            // Validasi apakah data transaksi tersedia
            if (empty($data['data']['data'])) {
                throw new \Exception('Riwayat transaksi tidak ditemukan.');
            }

            // Ambil data transaksi
            $riwayatTransaksi = $data['data']['data'];

            // Kirimkan data ke view
            return view('maha.riwa', compact('riwayatTransaksi'));

        } catch (\Exception $e) {
            // Tangani error dan kirimkan pesan error ke view
            return view('maha.riwa', [
                'riwayatTransaksi' => null,
                'error' => $e->getMessage(),
            ]);
        }
    }

}
