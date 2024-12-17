@extends('layouts.mainMhs')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="flex justify-between items-center mb-10">
    <!-- Filter Berdasarkan Tanggal -->
    <form method="GET" action="{{ route('maha.rw') }}" class="flex items-center">
        <input
            name="tanggal_mulai"
            class="border border-gray-300 p-2 rounded mr-2"
            placeholder="Tanggal Mulai (YYYY-MM-DD)"
            type="date"
            value="{{ request('tanggal_mulai') }}"
        />
        <div>-</div>
        <input
            name="tanggal_selesai"
            class="border border-gray-300 p-2 rounded mr-2"
            placeholder="Tanggal Selesai (YYYY-MM-DD)"
            type="date"
            value="{{ request('tanggal_selesai') }}"
        />
        <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded">
            Filter
        </button>
    </form>

    <!-- Tombol Cetak -->
    <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="printTable();">
        Cetak
    </button>
</div>

<div id="printableArea" class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full bg-white">
        <thead class="bg-blue-800 text-white">
        <tr>
            <th class="w-1/12 py-3 px-4 uppercase font-semibold text-sm">No</th>
            <th class="w-2/12 py-3 px-4 uppercase font-semibold text-sm">Periode</th>
            <th class="w-2/12 py-3 px-4 uppercase font-semibold text-sm">Deskripsi</th>
            <th class="w-2/12 py-3 px-4 uppercase font-semibold text-sm">Jumlah Tagihan</th>
            <th class="w-3/12 py-3 px-4 uppercase font-semibold text-sm">Status</th>
            <th class="w-3/12 py-3 px-4 uppercase font-semibold text-sm">Tanggal Pembaruan</th>
        </tr>
        </thead>
        <tbody class="text-gray-700">
            @if(isset($riwayatTransaksi) && count($riwayatTransaksi) > 0)
                @foreach($riwayatTransaksi as $index => $transaksi)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                        <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 text-center">{{ $transaksi['tagihan']['periode'] }}</td>
                        <td class="py-3 px-4 text-center">{{ $transaksi['tagihan']['deskripsi'] }}</td>
                        <td class="py-3 px-4 text-center">Rp. {{ number_format($transaksi['tagihan']['jmlh_tgh'], 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-center">{{ $transaksi['tagihan']['status_transaksi'] }}</td>
                        <td class="py-3 px-4 text-center">{{ $transaksi['tagihan']['updated_at'] }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center py-4">Tidak ada riwayat transaksi.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<div class="flex justify-center mt-10">
    <button
        class="bg-blue-800 text-white px-6 py-3 rounded"
        onclick="window.location.href='{{ route('maha.saldo') }}'">
        Kembali
    </button>
</div>

<script>
    // Fungsi untuk mencetak hanya tabel
    function printTable() {
        const printContent = document.getElementById('printableArea').innerHTML;
        const originalContent = document.body.innerHTML;

        // Buat jendela baru untuk mencetak
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
            <head>
                <title>Cetak Riwayat Transaksi</title>
                <style>
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: center;
                    }
                    th {
                        background-color: #1E3A8A;
                        color: white;
                    }
                    tr:nth-child(even) {
                        background-color: #f2f2f2;
                    }
                </style>
            </head>
            <body>
                ${printContent}
            </body>
            </html>
        `);
        printWindow.document.close(); // Tutup dokumen agar siap dicetak
        printWindow.print(); // Perintah cetak
    }
</script>
@endsection
