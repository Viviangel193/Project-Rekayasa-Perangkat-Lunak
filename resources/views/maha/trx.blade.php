@extends('layouts.mainMhs')

@section('title', 'Transaksi')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    @if(isset($error))
        <div class="text-red-600 font-bold">{{ $error }}</div>
    @else
        <h1 class="text-2xl font-bold text-green-600">Transaksi Berhasil!</h1>
        <p class="text-gray-600 mb-6">{{ now()->format('d F Y - H:i:s') }}</p>

        <div id="invoice-content" class="bg-blue-700 text-white p-10 rounded-lg shadow-lg">
            <div class="grid grid-cols-2 gap-4">
                <div>Kategori Pembayaran</div>
                <div>{{ $detail['deskripsi'] ?? 'SPP' }}</div>

                <div>Perguruan Tinggi</div>
                <div>Universitas Kristen Duta Wacana</div>

                <div>Nomor Pembayaran</div>
                <div>{{ $detail['no_va'] ?? 'Tidak tersedia' }}</div>

                <div>Nama</div>
                <div>{{ $mahasiswaDetail['nm_mhs'] ?? 'Nama Tidak Ditemukan' }}</div>

                <div>Program Studi</div>
                <div>{{ $mahasiswa->jurusan ?? 'Jurusan Tidak Ditemukan' }}</div>

                <div>Periode</div>
                <div>{{ $detail['periode'] ?? 'Tidak Tersedia' }}</div>

                <div class="col-span-2 border-t border-white my-4"></div>

                <div>Rincian</div>
                <div></div>

                <div>SKS</div>
                <div>{{ $detail['sks'] ?? 0 }} SKS</div>

                <div>ICE</div>
                <div>Rp. {{ $ice ?? 0 }}</div>

                <div>Potongan Prestasi</div>
                <div>Rp. {{ $potonganPrestasi ?? 0 }}</div>

                <div>Denda</div>
                <div>Rp. {{ $detail['denda'] === 'Iya' ? '25.000' : '0' }}</div>

                <div class="font-bold">Total Bayar</div>
                <div class="font-bold">Rp. {{ number_format($detail['jmlh_tgh'], 2, ',', '.') }}</div>
            </div>
        </div>
    @endif
</div>

<div class="mt-8 text-center">
    <button class="bg-blue-700 text-white px-6 py-2 rounded-lg" onclick="window.print();">
        CETAK INVOICE
    </button>
</div>
@endsection
