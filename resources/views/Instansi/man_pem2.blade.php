@extends('layouts.mainInstansi')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="bg-white p-8 rounded shadow-md">
    <form>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Mendapat Potongan/Diskon</label>
            <input class="w-full border border-blue-300 rounded p-2" type="text"/>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Kriteria</label>
            <textarea class="w-full border border-blue-300 rounded p-2 h-32"></textarea>
        </div>
        <div class="mb-4 flex items-center">
            <label class="block text-gray-700 mr-4">Potongan Harga</label>
            <span class="mr-2">Rp</span>
            <input class="border border-blue-300 rounded p-2" type="text"/>
        </div>
        <button class="bg-green-600 text-white px-4 py-2 rounded" type="submit">Simpan</button>
    </form>
</div>
@endsection
