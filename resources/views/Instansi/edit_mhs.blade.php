@extends('layouts.mainInstansi')

@section('title', 'Edit Data Mahasiswa')

@section('content')
<div class="container mx-auto mt-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Data Mahasiswa</h2>
        <form action="{{ route('instansi.updateMhs', $mahasiswa->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="nim" class="block text-gray-700 font-medium mb-2">NIM</label>
                <input type="text" name="nim" id="nim" value="{{ $mahasiswa->nim }}" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" required>
            </div>
            <div class="mb-4">
                <label for="nama_lengkap" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ $mahasiswa->nama_lengkap }}" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" required>
            </div>
            <div class="mb-4">
                <label for="angkatan" class="block text-gray-700 font-medium mb-2">Angkatan</label>
                <select name="angkatan" id="angkatan" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Angkatan</option>
                    <option value="2020" {{ $mahasiswa->angkatan == '2020' ? 'selected' : '' }}>2020</option>
                    <option value="2021" {{ $mahasiswa->angkatan == '2021' ? 'selected' : '' }}>2021</option>
                    <option value="2022" {{ $mahasiswa->angkatan == '2022' ? 'selected' : '' }}>2022</option>
                    <option value="2023" {{ $mahasiswa->angkatan == '2023' ? 'selected' : '' }}>2023</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="jurusan" class="block text-gray-700 font-medium mb-2">Jurusan</label>
                <select name="jurusan" id="jurusan" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Jurusan</option>
                    <option value="Sistem Informasi" {{ $mahasiswa->jurusan == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                    <option value="Informatika" {{ $mahasiswa->jurusan == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                    <option value="Manajemen" {{ $mahasiswa->jurusan == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                    <option value="Desain Produk" {{ $mahasiswa->jurusan == 'Desain Produk' ? 'selected' : '' }}>Desain Produk</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Jenis Kelamin</label>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="gender" value="L" class="mr-2 focus:ring focus:ring-blue-300" {{ $mahasiswa->jenis_kelamin == 'L' ? 'checked' : '' }}> Laki-laki
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="gender" value="P" class="mr-2 focus:ring focus:ring-blue-300" {{ $mahasiswa->jenis_kelamin == 'P' ? 'checked' : '' }}> Perempuan
                    </label>
                </div>
            </div>
            <div class="flex justify-end space-x-4">
                <a href="{{ route('instansi.mhs') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
