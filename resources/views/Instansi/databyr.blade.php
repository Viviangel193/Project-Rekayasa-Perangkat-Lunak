@extends('layouts.mainInstansi')

@section('title', 'Data Pembayaran')

@section('content')

<div class="flex justify-between items-center mb-5">
    <!-- Tombol Tambah Data -->
    <button
        class="bg-blue-600 text-white py-2 px-4 rounded-full flex items-center"
        onclick="window.location.href='{{ route('instansi.instansi.tmbh_byr') }}'">
        <i class="fas fa-plus mr-2"></i> Tambah Data
    </button>

    {{-- <!-- Form Pencarian -->
    <form action="{{ route('instansi.instansi.databyr') }}" method="GET" class="relative w-1/4">
        <input
            type="text"
            name="search"
            class="border border-gray-300 rounded-lg py-2 px-4 pl-10 w-full"
            placeholder="Cari..."
            value="{{ request()->get('search') }}" />
        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
    </form> --}}
</div>

{{-- Flash Message --}}
@if (session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<!-- Pembungkus untuk Scroll -->
<div class="overflow-x-auto">
    <table class="w-full bg-white rounded-lg shadow-lg table-fixed">
        <thead class="bg-blue-800 text-white text-sm">
            <tr>
                <th class="py-2 px-3 w-12">No</th>
                <th class="py-2 px-3 w-24">NIM</th>
                <th class="py-2 px-3 w-40">Periode</th>
                <th class="py-2 px-3 w-24">SKS</th>
                <th class="py-2 px-3 w-24">ICE</th>
                <th class="py-2 px-3 w-24">Kesehatan</th>
                <th class="py-2 px-3 w-24">Gedung</th>
                <th class="py-2 px-3 w-24">Prestasi</th>
                <th class="py-2 px-3 w-24">Denda</th>
                <th class="py-2 px-3 w-28">No. VA</th>
                <th class="py-2 px-3 w-28">Status Transaksi</th>
                <th class="py-2 px-3 w-40">Jumlah</th>
                <th class="py-2 px-3 w-36">Action</th>
            </tr>
        </thead>
        <tbody class="text-sm">
            @forelse($pembayaran as $key => $item)
                <tr class="{{ $key % 2 == 0 ? 'bg-gray-100' : '' }} border-b">
                    <td class="py-2 px-3 text-center">{{ $loop->iteration }}</td>
                    <td class="py-2 px-3 text-center">{{ $item['id_mahasiswa'] }}</td>
                    <td class="py-2 px-3 text-center">{{ $item['periode'] }}</td>
                    <td class="py-2 px-3 text-center">{{ $item['sks'] }}</td>
                    <td class="py-2 px-3 text-center">{{ $item['ice'] }}</td>
                    <td class="py-2 px-3 text-center">
                        Rp {{ number_format($item['detail_tagihan']['biaya_kesehatan'] ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="py-2 px-3 text-center">
                        Rp {{ number_format($item['detail_tagihan']['biaya_gedung'] ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="py-2 px-3 text-center">
                        Rp {{ number_format($item['detail_tagihan']['potongan_prestasi'] ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="py-2 px-3 text-center">
                        Rp {{ number_format($item['detail_tagihan']['hrg_denda'] ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="py-2 px-3">{{ $item['no_va'] }}</td>
                    <td class="py-2 px-3 text-center">{{ $item['status_transaksi'] }}</td>
                    <td class="py-2 px-3 text-center">
                        Rp {{ number_format($item['jmlh_tgh'], 0, ',', '.') }}
                    </td>
                    <td class="py-2 px-3 flex justify-center space-x-2">
                        <!-- Tombol Edit -->
                        <button class="bg-green-500 text-white py-1 px-3 rounded-lg text-xs">
                            <a href="{{ route('instansi.instansi.edit_byr', $item['id_tagihan']) }}">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </button>

                        <!-- Form Hapus -->
                        <form action="{{ route('instansi.instansi.deletePembayaran', $item['id_tagihan']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="py-2 px-3 text-center text-gray-500">Tidak ada data pembayaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- <!-- Pagination -->
<div class="mt-4">
    {{ $pembayaran->appends(request()->query())->links() }}
</div> --}}

@endsection
