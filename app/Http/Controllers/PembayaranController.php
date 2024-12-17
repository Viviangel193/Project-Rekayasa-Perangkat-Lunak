<?php

namespace App\Http\Controllers;

use App\Mahasiswa;
use App\Pembayaran;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PembayaranController extends Controller
{
    // Menampilkan daftar pembayaran
    public function index(Request $request)
    {
        // Ambil query pencarian dari request
        $search = $request->get('search');

        // Query untuk mengambil data pembayaran
        $pembayaran = Pembayaran::with('mahasiswa')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('id_mahasiswa', 'like', "%{$search}%")
                        ->orWhere('periode', 'like', "%{$search}%")
                        ->orWhereHas('mahasiswa', function ($query) use ($search) {
                            return $query->where('nama', 'like', "%{$search}%");
                        });
                });
            })
            ->paginate(10); // 10 adalah jumlah data per halaman

        return view('Instansi.databyr', compact('pembayaran'));
    }


    // Menampilkan form tambah pembayaran
    public function create()
    {
        $mahasiswa = Mahasiswa::all(); // Ambil data mahasiswa
        return view('Instansi.tmbh_byr', compact('mahasiswa'));
    }

    // Menyimpan data pembayaran
    public function store(Request $request)
    {
        // ngeinput data dari form web
        $validatedData = $request->validate([
            'id_mahasiswa' => 'required|exists:mahasiswas,nim',
            'periode' => 'required|string',
            'sks' => 'required|integer|min:1',
            'ice' => 'required|string|in:Iya,Tidak',
            'potongan_prestasi' => 'required|string|in:Iya,Tidak',
            'denda' => 'required|string|in:Iya,Tidak',
            'tgl_jth_tempo' => 'required|date',
            'deskripsi' => 'nullable|string'
        ]);

        try {
            // Ambil data mahasiswa berdasarkan nim
            $mahasiswa = Mahasiswa::where('nim', $validatedData['id_mahasiswa'])->firstOrFail();

            // Hitung detail tagihan
            $biayaSKS = 150000 * $validatedData['sks'];
            $biayaICE = ($validatedData['ice'] === 'Iya') ? 100000 : 0;
            $potonganPrestasi = ($validatedData['potongan_prestasi'] === 'Iya') ? 120000 : 0;
            $biayadenda = ($validatedData['denda'] === 'Iya') ? 25000 : 0;
            $biayaKesehatan = 50000;
            $biayaGedung = 100000;

            $jmlh_tgh = $biayaSKS + $biayaICE + $biayaKesehatan + $biayaGedung + $biayadenda - $potonganPrestasi;

            // data-data yang dikirim ke API
            $data = [
                'id_instansi' => 12345, // ID instansi Anda
                'id_mahasiswa' => $mahasiswa->nim,
                'jmlh_tgh' => number_format($jmlh_tgh, 2, '.', ''),
                'tgl_jth_tempo' => $validatedData['tgl_jth_tempo'],
                'deskripsi' => $validatedData['deskripsi'] ?? 'SPP',
                'periode' => $validatedData['periode'],
                'sks' => $validatedData['sks'],
                'ice' => $validatedData['ice'],
                'potongan_prestasi' => $validatedData['potongan_prestasi'],
                'denda' => $validatedData['denda'],
                'no_va' => rand(100000000000000, 999999999999999), // Nomor VA unik
                'status_transaksi' => 'Menunggu Pembayaran',
            ];

            $client = new \GuzzleHttp\Client();

            // Kirim request ke API
            $response = $client->post('https://termite-huge-mastodon.ngrok-free.app/api/tagihan', [
                'json' => $data,
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            // ini cuma nampilin pesan, pesannya antara pesan berhasil atau tidak berhasil
            $responseBody = json_decode($response->getBody(), true);
            \Log::info('Response API:', $responseBody);

            // dd($data); // ini kalau errornya data udah berhasil kekirim tapi ga semua kekirim

            // nampilin pesan berhasil
            if (isset($responseBody['success']) && $responseBody['success'] === true) {
                return redirect()->route('instansi.instansi.databyr')->with('success', 'Data pembayaran berhasil ditambahkan.');
            }

            // dari sini sampai akhir cuma nampilin pesen error
            $errorMessage = $responseBody['message'] ?? 'Respons API tidak jelas.';
            return redirect()->route('instansi.instansi.databyr')->with('error', 'Gagal menambahkan data pembayaran: ' . $errorMessage);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('instansi.instansi.databyr')->with('error', 'Mahasiswa tidak ditemukan.');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                $errorBody = $e->getResponse()->getBody()->getContents();
                \Log::error('API Error: ' . $errorBody);
                // dd($data); // ini kalau error, nampilin data apa yang dikirim biar kita bisa tau kita ngirim data apa
                return redirect()->route('instansi.instansi.databyr')->with('error', 'Gagal menghubungi API: ' . $errorBody);
            }

            return redirect()->route('instansi.instansi.databyr')->with('error', 'Gagal menyimpan data pembayaran: ' . $e->getMessage());
        } catch (\Exception $e) {
            \Log::error('Unexpected Error: ' . $e->getMessage());
            return redirect()->route('instansi.instansi.databyr')->with('error', 'Terjadi kesalahan tidak terduga.');
        }
    }

    // Menampilkan form edit pembayaran
    public function edit($id)
    {
        $client = new Client();

        try {
            // Dapatkan data tagihan berdasarkan ID dari API
            $response = $client->request('GET', "https://termite-huge-mastodon.ngrok-free.app/api/tagihan/{$id}");
            $data = json_decode($response->getBody(), true);

            if (!$data || !isset($data['data'])) {
                throw new \Exception('Data tagihan tidak ditemukan di API.');
            }

            // Data pembayaran untuk diisi di form
            $pembayaran = $data['data'];

            // Tambahkan data mahasiswa berdasarkan ID
            if (isset($pembayaran['id_mahasiswa'])) {
                $mahasiswa = Mahasiswa::where('id', $pembayaran['id_mahasiswa'])->first();
                $pembayaran['id_mahasiswa'] = $mahasiswa->nim ?? 'Tidak ditemukan';
            }

            return view('Instansi.edit_byr', compact('pembayaran'));
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                $errorBody = $e->getResponse()->getBody()->getContents();
                \Log::error('API Error (Edit): ' . $errorBody);
                return redirect()->route('instansi.instansi.databyr')->with('error', 'Gagal menghubungi API: ' . $errorBody);
            }

            \Log::error('Request Error (Edit): ' . $e->getMessage());
            return redirect()->route('instansi.instansi.databyr')->with('error', 'Terjadi kesalahan saat menghubungi API.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Data Mahasiswa Error (Edit): ' . $e->getMessage());
            return redirect()->route('instansi.instansi.databyr')->with('error', 'Data mahasiswa tidak ditemukan.');
        } catch (\Exception $e) {
            \Log::error('Unexpected Error (Edit): ' . $e->getMessage());
            return redirect()->route('instansi.instansi.databyr')->with('error', 'Terjadi kesalahan tidak terduga: ' . $e->getMessage());
        }
    }

    private function getMahasiswa()
    {
        // cURL untuk mengambil data mahasiswa
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://termite-huge-mastodon.ngrok-free.app/api/mahasiswa');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            // Tangani error cURL
            return [];
        }

        curl_close($ch);
        $data = json_decode($response, true);

        return $data['data'] ?? [];
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'periode' => 'required|string|max:255',
            'ice' => 'required|string|in:Iya,Tidak',
            'sks' => 'required|integer|min:1',
            'biaya_kesehatan' => 'required|numeric|min:0',
            'biaya_gedung' => 'required|numeric|min:0',
            'potongan_prestasi' => 'required|string|in:Iya,Tidak',
            'denda' => 'required|string|in:Iya,Tidak',
            'tgl_jth_tempo' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        // Format data yang akan dikirim ke API
        $data = [
            'periode' => $validated['periode'],
            'ice' => $validated['ice'],
            'sks' => $validated['sks'],
            'biaya_kesehatan' => $validated['biaya_kesehatan'],
            'biaya_gedung' => $validated['biaya_gedung'],
            'potongan_prestasi' => $validated['potongan_prestasi'],
            'denda' => $validated['denda'],
            'tgl_jth_tempo' => $validated['tgl_jth_tempo'],
            'deskripsi' => $validated['deskripsi'] ?? '',
        ];

        try {
            $client = new Client();
            $response = $client->request('PUT', "https://termite-huge-mastodon.ngrok-free.app/api/tagihan/{$id}", [
                'json' => $data,
                'headers' => ['Accept' => 'application/json'],
            ]);

            // ini cuma nampilin pesan, pesannya antara pesan berhasil atau tidak berhasil
            $responseBody = json_decode($response->getBody(), true);
            \Log::info('Response API:', $responseBody);

            // dd($data); // ini kalau errornya data udah berhasil kekirim tapi ga semua kekirim

            // nampilin pesan berhasil
            if (isset($responseBody['success']) && $responseBody['success'] === true) {
                return redirect()->route('instansi.instansi.databyr')->with('success', 'Data pembayaran berhasil diubah.');
            }

            // dari sini sampai akhir cuma nampilin pesen error
            $errorMessage = $responseBody['message'] ?? 'Respons API tidak jelas.';
            return redirect()->route('instansi.instansi.databyr')->with('error', 'Gagal mengubah data pembayaran: ' . $errorMessage);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('instansi.instansi.databyr')->with('error', 'Mahasiswa tidak ditemukan.');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                $errorBody = $e->getResponse()->getBody()->getContents();
                \Log::error('API Error: ' . $errorBody);
                // dd($data); // ini kalau error, nampilin data apa yang dikirim biar kita bisa tau kita ngirim data apa
                return redirect()->route('instansi.instansi.databyr')->with('error', 'Gagal menghubungi API: ' . $errorBody);
            }

            return redirect()->route('instansi.instansi.databyr')->with('error', 'Gagal menyimpan data pembayaran: ' . $e->getMessage());
        } catch (\Exception $e) {
            \Log::error('Unexpected Error: ' . $e->getMessage());
            return redirect()->route('instansi.instansi.databyr')->with('error', 'Terjadi kesalahan tidak terduga.');
        }
    }

    // Menghapus data pembayaran
    public function destroy($id)
    {
        $client = new Client();

        try {
            $response = $client->request('DELETE', "https://termite-huge-mastodon.ngrok-free.app/api/tagihan/$id");

            return redirect()->route('instansi.instansi.databyr')->with('success', 'Data pembayaran berhasil dihapus melalui API.');
        } catch (\Exception $e) {
            return redirect()->route('instansi.instansi.databyr')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function databyr()
    {
        $client = new Client();

        try {
            // Perform GET request to API
            $response = $client->request('GET', 'https://termite-huge-mastodon.ngrok-free.app/api/tagihan');
            $data = json_decode($response->getBody(), true); // Decode JSON response

            // Extract only the data array from the response
            $pembayaran = $data['data']['data'] ?? []; // Safeguard if the structure changes

            // Cast `jmlh_tgh` to numeric in case it's used in calculations
            foreach ($pembayaran as &$item) {
                $item['jmlh_tgh'] = isset($item['jmlh_tgh']) ? (float) $item['jmlh_tgh'] : 0;
            }

            return view('Instansi.databyr', compact('pembayaran'));
        } catch (\Exception $e) {
            // Handle errors gracefully and pass an error message to the view
            return view('Instansi.databyr', ['pembayaran' => [], 'error' => $e->getMessage()]);
        }
    }
}
