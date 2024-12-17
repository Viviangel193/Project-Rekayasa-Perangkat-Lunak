@extends('layouts.mainInstansi')

@section('title', 'Manajemen Pembayaran')

@section('content')

    @if (isset($error))
        <div class="bg-red-100 text-red-600 p-4 mb-4">
            {{ $error }}
        </div>
    @endif

    <!-- Tabel Komponen Pembayaran -->
    <div class="bg-white shadow-md rounded-lg p-4 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-blue-900">Komponen Pembayaran</h2>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-blue-900 text-white">
                    <th class="p-2">Kategori Pembayaran</th>
                    <th class="p-2">Deskripsi</th>
                    <th class="p-2">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    @if (!str_contains($item['kategori_komponen'], 'Berprestasi'))
                        <tr class="border-b">
                            <td class="p-2">{{ $item['kategori_komponen'] }}</td>
                            <td class="p-2">{{ $item['deskripsi_komponen'] }}</td>
                            <td class="p-2">Rp. {{ number_format($item['jumlah_komponen'], 0, ',', '.') }}</td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="3" class="text-center p-4">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tabel Potongan/Diskon -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-blue-900">Potongan/Diskon</h2>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-blue-900 text-white">
                    <th class="p-2">Kategori Potongan/Diskon</th>
                    <th class="p-2">Deskripsi</th>
                    <th class="p-2">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    @if (str_contains($item['kategori_komponen'], 'Berprestasi'))
                        <tr class="border-b">
                            <td class="p-2">{{ $item['kategori_komponen'] }}</td>
                            <td class="p-2">{{ $item['deskripsi_komponen'] }}</td>
                            <td class="p-2">Rp. {{ number_format($item['jumlah_komponen'], 0, ',', '.') }}</td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="3" class="text-center p-4">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
