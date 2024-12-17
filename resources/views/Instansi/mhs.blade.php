@extends('layouts.mainInstansi')

@section('title', 'Tambah Data Mahasiswa')

@section('content')
<div class="flex justify-between items-center mb-5">
    <!-- Tombol Tambah Data -->
    <button
        class="bg-blue-600 text-white py-2 px-4 rounded-full shadow hover:bg-blue-700"
        onclick="window.location.href='{{ route('instansi.tambahMhsForm') }}'">
        <i class="fas fa-plus mr-2"></i> Tambah Data
    </button>

    <!-- Filter Section -->
    <form method="GET" action="{{ route('instansi.mhs') }}" class="flex items-center space-x-4 w-full justify-end">
        <!-- Input Pencarian -->
        <div class="relative">
            <input
                type="text"
                name="search"
                class="border border-gray-300 rounded-lg py-2 px-4 pl-10 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Cari..."
                value="{{ request()->query('search') }}" />
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>

        <!-- Filter Jenis Kelamin -->
        <div>
            <select
                name="jenis_kelamin"
                onchange="this.form.submit()"
                class="border border-gray-300 rounded-lg py-2 px-4 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">Semua Jenis Kelamin</option>
                <option value="L" {{ request()->query('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ request()->query('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
    </form>
</div>

    <table class="w-full bg-white rounded-lg shadow-lg">
        <thead class="bg-blue-800 text-white">
            <tr>
                <th class="py-3 px-4">No</th>
                <th class="py-3 px-4">Nim</th>
                <th class="py-3 px-4">Nama</th>
                <th class="py-3 px-4">Angkatan</th>
                <th class="py-3 px-4">Jurusan</th>
                <th class="py-3 px-4">Jenis Kelamin</th>
                <th class="py-3 px-4">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mahasiswas as $mahasiswa)
                <tr class="border-b">
                    <td class="py-3 px-4">{{ $loop->iteration + ($mahasiswas->currentPage() - 1) * $mahasiswas->perPage() }}</td>
                    <td class="py-3 px-4">{{ $mahasiswa->nim }}</td>
                    <td class="py-3 px-4">{{ $mahasiswa->nama_lengkap }}</td>
                    <td class="py-3 px-4">{{ $mahasiswa->angkatan }}</td>
                    <td class="py-3 px-4">{{ $mahasiswa->jurusan }}</td>
                    <td class="py-3 px-4">{{ $mahasiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td class="py-1 px-2 flex space-x-2">
                        <a href="{{ route('instansi.editMhsForm', $mahasiswa->id) }}"
                            class="bg-green-500 text-white py-1 px-4 rounded-lg flex items-center">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>
                        <form action="{{ route('instansi.deleteMhs', $mahasiswa->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button
                                class="bg-red-500 text-white py-1 px-4 rounded-lg flex items-center"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash mr-2"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="py-3 px-4 text-center">Tidak ada data mahasiswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

<!-- Horizontal Pagination Links -->
<div class="mt-6 flex justify-center">
    <ul class="flex space-x-2 items-center">
        {{-- Previous Page Link --}}
        @if ($mahasiswas->onFirstPage())
            <li class="py-2 px-4 bg-gray-300 text-gray-500 rounded cursor-not-allowed">← Prev</li>
        @else
            <li>
                <a href="{{ $mahasiswas->previousPageUrl() }}" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600">
                    ← Prev
                </a>
            </li>
        @endif

        {{-- Pagination Links --}}
        @foreach ($mahasiswas->getUrlRange(1, $mahasiswas->lastPage()) as $page => $url)
            @if ($page == $mahasiswas->currentPage())
                <li class="py-2 px-4 bg-blue-600 text-white rounded">{{ $page }}</li>
            @else
                <li>
                    <a href="{{ $url }}" class="py-2 px-4 bg-gray-300 text-blue-500 rounded hover:bg-blue-500 hover:text-white">
                        {{ $page }}
                    </a>
                </li>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($mahasiswas->hasMorePages())
            <li>
                <a href="{{ $mahasiswas->nextPageUrl() }}" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Next →
                </a>
            </li>
        @else
            <li class="py-2 px-4 bg-gray-300 text-gray-500 rounded cursor-not-allowed">Next →</li>
        @endif
    </ul>
</div>
@endsection
