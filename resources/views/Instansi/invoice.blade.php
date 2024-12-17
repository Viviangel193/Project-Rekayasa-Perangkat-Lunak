@extends('layouts.mainInstansi')

@section('title', 'Invoice Tagihan')

@section('content')
<div class="bg-white p-8 rounded shadow">
    <h2 class="text-xl font-bold mb-6 text-center">Invoice Pembayaran</h2>

    <!-- Bagian Data Diri Mahasiswa -->
    <div class="border p-6 rounded shadow mb-6">
        <h3 class="font-semibold text-lg mb-4">Mahasiswa</h3>
        <table class="table-auto w-full text-sm">
            <tr>
                <td class="font-medium w-1/3">Nama Mahasiswa</td>
                <td>: {{ $invoiceData['nama_mahasiswa'] }}</td>
            </tr>
            <tr>
                <td class="font-medium w-1/3">Program Studi</td>
                <td>: {{ $invoiceData['program_studi'] }}</td>
            </tr>
            <tr>
                <td class="font-medium w-1/3">NIM</td>
                <td>: {{ $invoiceData['nim'] }}</td>
            </tr>
            <tr>
                <td class="font-medium w-1/3">Periode</td>
                <td>: {{ $invoiceData['periode'] }}</td>
            </tr>
        </table>
    </div>

    <!-- Bagian Tagihan -->
    <div class="border p-6 rounded shadow mb-6">
        <h3 class="font-semibold text-lg mb-4">Detail Tagihan</h3>
        <table class="table-auto w-full text-sm">
            <tr>
                <td class="font-medium w-1/3">Kategori Pembayaran</td>
                <td>: {{ $invoiceData['kategori_pembayaran'] }}</td>
            </tr>
            <tr>
                <td class="font-medium w-1/3">Nomor VA</td>
                <td>: {{ $invoiceData['nomor_pembayaran'] }}</td>
            </tr>
            <tr>
                <td class="font-medium w-1/3">Total Tagihan</td>
                <td>: Rp. {{ number_format($invoiceData['tagihan'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="font-medium w-1/3">SKS</td>
                <td>: {{ $invoiceData['sks'] }}</td>
            </tr>
            <tr>
                <td class="font-medium w-1/3">Biaya Kesehatan</td>
                <td>: Rp. {{ number_format($invoiceData['biaya_kesehatan'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="font-medium w-1/3">Biaya Gedung</td>
                <td>: Rp. {{ number_format($invoiceData['biaya_gedung'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="font-medium w-1/3">Potongan Prestasi</td>
                <td>: Rp. {{ number_format($invoiceData['potongan_prestasi'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="font-medium w-1/3">Denda</td>
                <td>: Rp. {{ number_format($invoiceData['denda'], 0, ',', '.') }}</td>
            </tr>
            <tr class="font-semibold">
                <td class="font-medium w-1/3">Total Pembayaran</td>
                <td>: Rp. {{ number_format($invoiceData['total_bayar'], 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <!-- Tombol Cetak -->
    <div class="text-center mt-6">
        <button onclick="window.print()" class="bg-blue-700 text-white py-2 px-4 rounded hover:bg-blue-800">
            Cetak Invoice
        </button>
    </div>
</div>
@endsection
