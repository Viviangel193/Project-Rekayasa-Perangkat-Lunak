@extends('layouts.mainInstansi')

@section('title', 'Data Transaksi')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <form action="{{ route('instansi.dataTrx') }}" method="GET" class="relative">
            <input
                name="search"
                value="{{ request('search') }}"
                class="border border-gray-300 rounded-full py-2 px-4 pl-10"
                placeholder="Cari NIM, Nama, atau Status Pembayaran"
                type="text" />
            <button type="submit" class="absolute left-3 top-2 text-gray-400">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

@if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p>{{ session('error') }}</p>
    </div>
@endif

<table class="w-full bg-white rounded-lg shadow-lg">
    <thead class="bg-blue-900 text-white">
        <tr>
            <th class="py-3 px-4">NIM</th>
            <th class="py-3 px-4">Nama</th>
            <th class="py-3 px-4">Total Pembayaran</th>
            <th class="py-3 px-4">Tanggal Jatuh Tempo</th>
            <th class="py-3 px-4">Status Pembayaran</th>
            <th class="py-3 px-4">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($transactions as $transaction)
        <tr class="border-b">
            <td class="py-3 px-4">{{ $transaction['id_mahasiswa'] }}</td>
            <td class="py-3 px-4">{{ $transaction['nama_mahasiswa'] }}</td>
            <td class="py-3 px-4">Rp. {{ number_format($transaction['jmlh_tgh'], 0, ',', '.') }}</td>
            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($transaction['tgl_jth_tempo'])->format('d-m-Y') }}</td>
            <td class="py-3 px-4">{{ $transaction['status_transaksi'] }}</td>
            <td class="py-3 px-4">
                <a href="{{ route('instansi.cetak', ['id_tagihan' => $transaction['id_tagihan']]) }}"
                   class="bg-blue-700 text-white p-2 rounded">
                   Cetak
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center py-4">Tidak ada data transaksi</td>
        </tr>
        @endforelse
    </tbody>
</table>

@if(request('search'))
    <div class="mt-4 text-gray-600">
        <p>Menampilkan hasil pencarian untuk: <strong>{{ request('search') }}</strong></p>
    </div>
@endif
@endsection
