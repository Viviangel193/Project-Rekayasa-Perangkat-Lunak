@extends('layouts.mainInstansi')

@section('title', 'Tambah Data Mahasiswa')

@section('content')
<div class="container mx-auto mt-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Tambah Data Mahasiswa</h2>
        <form action="{{ route('instansi.storeMhs') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nim" class="block text-gray-700 font-medium mb-2">NIM</label>
                <input type="text" name="nim" id="nim"
       class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300"
       placeholder="Masukkan NIM" required
       maxlength="8" pattern="\d{8}" title="NIM harus terdiri dari 8 digit angka">
            </div>
            <div class="mb-4">
                <label for="nama_lengkap" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" placeholder="Masukkan Nama Lengkap" required>
            </div>
            <div class="mb-4">
                <label for="angkatan" class="block text-gray-700 font-medium mb-2">Angkatan</label>
                <select name="angkatan" id="angkatan" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Angkatan</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="jurusan" class="block text-gray-700 font-medium mb-2">Jurusan</label>
                <select name="jurusan" id="jurusan" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Jurusan</option>
                    <option value="Sistem Informasi">Sistem Informasi</option>
                    <option value="Informatika">Informatika</option>
                    <option value="Manajemen">Manajemen</option>
                    <option value="Desain Produk">Desain Produk</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Jenis Kelamin</label>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="gender" value="L" class="mr-2 focus:ring focus:ring-blue-300" required> Laki-laki
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="gender" value="P" class="mr-2 focus:ring focus:ring-blue-300" required> Perempuan
                    </label>
                </div>
            </div>
            <div class="flex justify-end space-x-4">
                <a href="{{ route('instansi.mhs') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
