@extends('layouts.mainMhs')

@section('title', 'Pembayaran')

@section('content')
<div class="bg-blue-700 text-white p-5 rounded-lg mb-10">
    <div class="flex items-center mb-4">
        <i class="fas fa-file-invoice-dollar text-2xl mr-4"></i>
        <span class="text-xl">SALDO</span>
    </div>

    <!-- Menampilkan pesan error jika ada -->
    @if(session('error'))
        <div class="bg-red-600 text-white text-center py-2 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Menampilkan saldo -->
    <div class="bg-white text-red-600 text-center py-2 rounded-lg">
        Rp.{{ number_format($saldo ?? 0, 0, ',', '.') }}
    </div>
</div>

    <div class="flex justify-around space-x-4">
        <!-- Button Pembayaran -->
        <button class="bg-white p-5 rounded-lg shadow-lg text-center w-1/3 hover:shadow-xl transition duration-200"
        onclick="window.location.href='{{ route('maha.pb') }}'">
            <i class="fas fa-exchange-alt text-4xl text-blue-700 mb-4"></i>
            <div class="text-xl text-blue-700">PEMBAYARAN</div>
        </button>

        <!-- Button Riwayat Pembayaran -->
        <button class="bg-white p-5 rounded-lg shadow-lg text-center w-1/3 hover:shadow-xl transition duration-200"
        onclick="window.location.href='{{ route('maha.rw') }}'">
            <i class="fas fa-history text-4xl text-blue-700 mb-4"></i>
            <div class="text-xl text-blue-700">RIWAYAT PEMBAYARAN</div>
        </button>
    </div>
@endsection
