@extends('layouts.mainMhs')

@section('title', 'Pembayaran')

@section('content')
    <div class="w-10/5 p-15">
        <!-- Display Error Message -->
        @if(isset($error) && $error)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Error:</strong> {{ $error }}
            </div>
        @endif

        <!-- Payment Section -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h2 class="text-blue-800 font-bold mb-4">
                INFORMASI PEMBAYARAN
            </h2>
            <p class="text-gray-800 mb-4">
                Nomor Virtual Account Anda:
                <strong>{{ $virtualAccount ?? 'Tidak tersedia' }}</strong>
            </p>
            <button class="bg-blue-500 text-white px-4 py-2 rounded"
                    onclick="window.location.href='{{ route('maha.saldo') }}'">
                BAYAR
            </button>
        </div>

        <!-- Data Pembayaran -->
        <div class="bg-white p-6 rounded shadow mb-10">
            <h2 class="text-blue-800 font-bold mb-4">
                DATA PEMBAYARAN SPP
            </h2>
            <table class="table-auto w-full border">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border p-2 text-center">NO.</th>
                        <th class="border p-2 text-center">SEMESTER</th>
                        <th class="border p-2 text-center">TOTAL TAGIHAN (Rp)</th>
                        <th class="border p-2 text-center">BEASISWA/PINJAMAN/ANGSURAN (Rp)</th>
                        <th class="border p-2 text-center">STATUS</th>
                        <th class="border p-2 text-center">TANGGAL TERAKHIR UPDATE</th>
                    </tr>
                </thead>
                <tbody>
                    @if(is_array($tagihanList) || $tagihanList instanceof \Illuminate\Support\Collection)
                        @forelse($tagihanList as $index => $item)
                            <tr>
                                <td class="border p-2 text-center">{{ $index + 1 }}</td>
                                <td class="border p-2 text-center">{{ $item['tagihan']['periode'] ?? '-' }}</td>
                                <td class="border p-2 text-center">{{ number_format($item['tagihan']['jmlh_tgh'] ?? 0, 2, ',', '.') }}</td>
                                <td class="border p-2 text-center">{{ number_format($item['tagihan']['potongan_prestasi'] === 'Iya' ? '120.000' : '0') }}</td>
                                <td class="border p-2 text-center">{{ $item['tagihan']['status_transaksi'] ?? 'Tidak Diketahui' }}</td>
                                <td class="border p-2 text-center">{{ \Carbon\Carbon::parse($item['updated_at'])->format('d-m-Y H:i') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="border p-4 text-center text-red-500">Tidak ada data tagihan tersedia</td>
                            </tr>
                        @endforelse
                    @else
                        <tr>
                            <td colspan="8" class="border p-4 text-center text-red-500">Data tagihan tidak valid atau tidak ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
