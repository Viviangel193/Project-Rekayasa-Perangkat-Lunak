@extends('layouts.mainInstansi')

@section('title', 'Tambah Pembayaran')

@section('content')

<div class="bg-white p-5 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Tambah Data Pembayaran</h2>
    <form action="{{ route('instansi.instansi.store') }}" method="POST">
        @csrf

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Pilihan Mahasiswa --}}
        <div class="mb-4">
            <label for="id_mahasiswa" class="block text-sm font-medium text-gray-700">Mahasiswa</label>
            <select name="id_mahasiswa" id="id_mahasiswa" class="border border-gray-300 rounded w-full">
                <option value="" disabled selected>Pilih Mahasiswa</option>
                @foreach($mahasiswa as $item)
                <option value="{{ $item->nim }}" {{ old('id_mahasiswa') == $item->nim ? 'selected' : '' }}>
                    {{ $item->nim }} - {{ $item->nama }}
                </option>
                @endforeach
            </select>
            @error('id_mahasiswa')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input untuk Periode --}}
        <div class="mb-4">
            <label for="periode" class="block text-sm font-medium text-gray-700">Periode</label>
            <input type="text" name="periode" id="periode" value="{{ old('periode') }}" class="border border-gray-300 rounded w-full p-2" placeholder="Misal: 2024/2025">
            @error('periode')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Radio Button untuk ICE --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">ICE</label>
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="radio" name="ice" value="Iya" class="text-blue-500 focus:ring-blue-400" {{ old('ice') === 'Iya' ? 'checked' : '' }}>
                    <span class="ml-2">Iya</span>
                </label>
                <label class="inline-flex items-center ml-4">
                    <input type="radio" name="ice" value="Tidak" class="text-blue-500 focus:ring-blue-400" {{ old('ice') === 'Tidak' ? 'checked' : '' }}>
                    <span class="ml-2">Tidak</span>
                </label>
            </div>
            @error('ice')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input untuk SKS --}}
        <div class="mb-4">
            <label for="sks" class="block text-sm font-medium text-gray-700">Jumlah SKS</label>
            <input type="number" name="sks" id="sks" value="{{ old('sks') }}" class="border border-gray-300 rounded w-full p-2" placeholder="Jumlah SKS">
            @error('sks')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Radio Button untuk Potongan Prestasi --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Potongan Prestasi</label>
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="radio" name="potongan_prestasi" value="Iya" class="text-blue-500 focus:ring-blue-400" {{ old('potongan_prestasi') === 'Iya' ? 'checked' : '' }}>
                    <span class="ml-2">Iya</span>
                </label>
                <label class="inline-flex items-center ml-4">
                    <input type="radio" name="potongan_prestasi" value="Tidak" class="text-blue-500 focus:ring-blue-400" {{ old('potongan_prestasi') === 'Tidak' ? 'checked' : '' }}>
                    <span class="ml-2">Tidak</span>
                </label>
            </div>
            @error('potongan_prestasi')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Radio Button untuk Denda --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Denda</label>
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="radio" name="denda" value="Iya" class="text-blue-500 focus:ring-blue-400" {{ old('denda') === 'Iya' ? 'checked' : '' }}>
                    <span class="ml-2">Iya</span>
                </label>
                <label class="inline-flex items-center ml-4">
                    <input type="radio" name="denda" value="Tidak" class="text-blue-500 focus:ring-blue-400" {{ old('denda') === 'Tidak' ? 'checked' : '' }}>
                    <span class="ml-2">Tidak</span>
                </label>
            </div>
            @error('denda')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input untuk Tanggal Jatuh Tempo --}}
        <div class="mb-4">
            <label for="tgl_jth_tempo" class="block text-sm font-medium text-gray-700">Tanggal Jatuh Tempo</label>
                <input type="date" name="tgl_jth_tempo" id="tgl_jth_tempo" value="{{ old('tgl_jth_tempo') }}" class="border border-gray-300 rounded w-full p-2">
            @error('tgl_jth_tempo')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input untuk Deskripsi --}}
        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="border border-gray-300 rounded w-full p-2" rows="3" placeholder="Masukkan deskripsi pembayaran">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Simpan --}}
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
    </form>
</div>

@endsection
