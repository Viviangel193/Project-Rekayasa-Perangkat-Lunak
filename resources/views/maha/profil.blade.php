{{-- resources\views\maha\profil.blade.php --}}
@extends('layouts.mainMhs')

@section('title', 'Profil')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md border border-blue-500">
    <h2 class="text-2xl font-bold text-center mb-6">BIODATA MAHASISWA/I</h2>
    <div class="flex items-center justify-center mb-6">
        <div class="w-32 h-32 bg-gray-200 rounded-full overflow-hidden">
            <img
                src="https://img-z.okeinfo.net/library/images/2018/08/21/tlbj82e0l51ezsheoijn_21294.jpeg"
                class="object-cover w-full h-full"
            />
        </div>
    </div>
    <div class="text-lg">
        <p class="mb-2 flex">
            <span class="font-bold w-1/3">Nomor Induk Mahasiswa/i</span>
            <span class="w-2/3">{{ $mahasiswa->nim }}</span>
        </p>
        <p class="mb-2 flex">
            <span class="font-bold w-1/3">Nama Lengkap</span>
            <span class="w-2/3">{{ $mahasiswa->nama_lengkap }}</span>
        </p>
        <p class="mb-2 flex">
            <span class="font-bold w-1/3">Jenis Kelamin</span>
            <span class="w-2/3">
                {{ $mahasiswa->jenis_kelamin == 'P' ? 'Perempuan' : ($mahasiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Tidak Diketahui') }}
            </span>
        </p>
        <p class="mb-2 flex">
            <span class="font-bold w-1/3">Angkatan</span>
            <span class="w-2/3">{{ $mahasiswa->angkatan }}</span>
        </p>
        <p class="mb-2 flex">
            <span class="font-bold w-1/3">Jurusan</span>
            <span class="w-2/3">{{ $mahasiswa->jurusan }}</span>
        </p>
    </div>
</div>
@endsection
