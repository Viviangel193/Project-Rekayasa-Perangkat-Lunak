@extends('layouts.mainMhs')

@section('title', 'Transaksi')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">

    <div id="invoice-content" class="bg-blue-700 text-white p-10 rounded-lg shadow-lg">
        <div class="grid grid-cols-2 gap-4">
            <h1 class="text-2xl font-bold text-black-600">Detail Transaksi</h1>
            <div></div>
            <!-- Kategori Pembayaran -->
            <div>Kategori Pembayaran</div>
            <div>{{ $detail['deskripsi'] }}</div>

            <!-- Perguruan Tinggi -->
            <div>Perguruan Tinggi</div>
            <div>Universitas Kristen Duta Wacana</div>

            <!-- Nomor Pembayaran -->
            <div>Nomor Pembayaran</div>
            <div>{{ $detail['no_va'] }}</div>

            <!-- Nama Mahasiswa -->
            <div>Nama</div>
            <div>{{ $mahasiswa ? $mahasiswa->nama_lengkap : 'Nama Tidak Ditemukan' }}</div>

            <!-- Program Studi -->
            <div>Program Studi</div>
            <div>{{ $mahasiswa ? $mahasiswa->jurusan : 'Jurusan Tidak Ditemukan' }}</div>

            <!-- Periode -->
            <div>Periode</div>
            <div>{{ $detail['periode'] }}</div>

            <!-- Rincian -->
            <div class="col-span-2 border-t border-white my-4"></div>
            <div>Rincian</div>
            <div></div>

            {{-- <!-- Tagihan -->
            <div>Tagihan</div>
            <div>Rp. {{ number_format($detail['jmlh_tgh'], 2, ',', '.') }}</div> --}}

            <!-- SKS -->
            <div>SKS</div>
            <div>{{ $detail['sks'] }} SKS</div>

            <!-- ICE -->
            <div>ICE</div>
            <div>Rp. {{ $detail['ice'] === 'Iya' ? '100.000' : '0' }}</div>

            <!-- Potongan Prestasi -->
            <div>Potongan Prestasi</div>
            <div>Rp. {{ $detail['potongan_prestasi'] === 'Iya' ? '120.000' : '0' }}</div>

            <!-- Denda -->
            <div>Denda</div>
            <div>Rp. {{ $detail['denda'] === 'Iya' ? '25.000' : '0' }}</div>

            <!-- Total Bayar -->
            <div class="font-bold">Total Bayar</div>
            <div class="font-bold">Rp. {{ number_format($detail['jmlh_tgh'], 2, ',', '.') }}</div>
        </div>
    </div>

</div>

    {{-- <!-- Button untuk cetak invoice -->
    <div class="mt-8 text-center">
        <button class="bg-blue-700 text-white px-6 py-2 rounded-lg" onclick="window.print();">
            CETAK INVOICE
        </button>
    </div> --}}

<!-- Tombol untuk melanjutkan pembayaran -->
<div class="mt-6 text-center">
    <a href="{{ route('maha.trx') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg">
        Bayar
    </a>
</div>

@endsection
