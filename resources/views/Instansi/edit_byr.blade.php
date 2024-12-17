@extends('layouts.mainInstansi')

@section('title', 'Edit Pembayaran')

@section('content')

<div class="bg-white p-5 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Edit Data Pembayaran</h2>

    @if($pembayaran) <!-- Periksa apakah $pembayaran ada -->
    <form action="{{ route('instansi.instansi.update', $pembayaran['id_tagihan']) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Input Hidden ID Mahasiswa -->
        <input type="hidden" name="id_mahasiswa" value="{{ $pembayaran['id_mahasiswa'] }}">

        <!-- Input Periode -->
        <div class="mb-4">
            <label for="periode" class="block text-sm font-medium text-gray-700">Periode</label>
            <input type="text" name="periode" id="periode" class="border border-gray-300 rounded w-full p-2"
                   value="{{ old('periode', $pembayaran['periode'] ?? '') }}" placeholder="Misal: 2024/2025">
        </div>

        <!-- Radio Button ICE -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">ICE</label>
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="radio" name="ice" value="Iya"
                           class="text-blue-500 focus:ring-blue-400"
                           {{ old('ice', $pembayaran['ice']) == 'Iya' ? 'checked' : '' }}>
                    <span class="ml-2">Iya</span>
                </label>
                <label class="inline-flex items-center ml-4">
                    <input type="radio" name="ice" value="Tidak"
                           class="text-blue-500 focus:ring-blue-400"
                           {{ old('ice', $pembayaran['ice']) == 'Tidak' ? 'checked' : '' }}>
                    <span class="ml-2">Tidak</span>
                </label>
            </div>
        </div>

        <!-- Input Jumlah SKS -->
        <div class="mb-4">
            <label for="sks" class="block text-sm font-medium text-gray-700">Jumlah SKS</label>
            <input type="number" name="sks" id="sks" class="border border-gray-300 rounded w-full p-2"
                   value="{{ old('sks', $pembayaran['sks'] ?? 0) }}" placeholder="Jumlah SKS">
        </div>

        <!-- Input biaya Kesehatan -->
        <div class="mb-4">
            <label for="biaya_kesehatan" class="block text-sm font-medium text-gray-700">biaya Kesehatan</label>
            <input type="number" name="biaya_kesehatan" id="biaya_kesehatan" class="border border-gray-300 rounded w-full p-2"
                   value="{{ old('biaya_kesehatan', $pembayaran['detail_tagihan']['biaya_kesehatan'] ?? 0) }}"
                   placeholder="Jumlah biaya Kesehatan">
        </div>

        <!-- Input biaya Gedung -->
        <div class="mb-4">
            <label for="biaya_gedung" class="block text-sm font-medium text-gray-700">biaya Gedung</label>
            <input type="number" name="biaya_gedung" id="biaya_gedung" class="border border-gray-300 rounded w-full p-2"
                   value="{{ old('biaya_gedung', $pembayaran['detail_tagihan']['biaya_gedung'] ?? 0) }}"
                   placeholder="Jumlah biaya Gedung">
        </div>

        <!-- Radio Button Potongan Prestasi -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Potongan Prestasi</label>
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="radio" name="potongan_prestasi" value="Iya"
                           class="text-blue-500 focus:ring-blue-400"
                           {{ old('potongan_prestasi', $pembayaran['potongan_prestasi']) == 'Iya' ? 'checked' : '' }}>
                    <span class="ml-2">Iya</span>
                </label>
                <label class="inline-flex items-center ml-4">
                    <input type="radio" name="potongan_prestasi" value="Tidak"
                           class="text-blue-500 focus:ring-blue-400"
                           {{ old('potongan_prestasi', $pembayaran['potongan_prestasi']) == 'Tidak' ? 'checked' : '' }}>
                    <span class="ml-2">Tidak</span>
                </label>
            </div>
        </div>

        <!-- Radio Button Denda -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Denda</label>
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="radio" name="denda" value="Iya"
                           class="text-blue-500 focus:ring-blue-400"
                           {{ old('denda', $pembayaran['denda']) == 'Iya' ? 'checked' : '' }}>
                    <span class="ml-2">Iya</span>
                </label>
                <label class="inline-flex items-center ml-4">
                    <input type="radio" name="denda" value="Tidak"
                           class="text-blue-500 focus:ring-blue-400"
                           {{ old('denda', $pembayaran['denda']) == 'Tidak' ? 'checked' : '' }}>
                    <span class="ml-2">Tidak</span>
                </label>
            </div>
        </div>

        <!-- Input Tanggal Jatuh Tempo -->
        <div class="mb-4">
            <label for="tgl_jth_tempo" class="block text-sm font-medium text-gray-700">Tanggal Jatuh Tempo</label>
            <input type="date" name="tgl_jth_tempo" id="tgl_jth_tempo" class="border border-gray-300 rounded w-full p-2"
                   value="{{ old('tgl_jth_tempo', $pembayaran['tgl_jth_tempo'] ?? '') }}">
        </div>

        <!-- Input Deskripsi -->
        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="border border-gray-300 rounded w-full p-2" rows="3"
                      placeholder="Masukkan deskripsi pembayaran">{{ old('deskripsi', $pembayaran['deskripsi'] ?? '') }}</textarea>
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
    </form>
    @else
        <p class="text-red-500">Data pembayaran tidak ditemukan.</p>
    @endif
</div>

@endsection
