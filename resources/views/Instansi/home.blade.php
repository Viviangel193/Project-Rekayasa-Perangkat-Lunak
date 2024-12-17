@extends('layouts.mainInstansi')

@section('title', 'Home - Dashboard Instansi')
@section('header-title', 'Dashboard Utama')

@section('content')
<!-- Main Content -->
<div class="grid grid-cols-3 gap-4 mb-8">
    <div class="bg-gray-200 p-4 rounded flex items-center justify-between">
        <div class="flex items-center">
            <i class="fas fa-user-graduate text-4xl text-blue-600 mr-4"></i>
            <div>
                <div class="text-gray-600">Total Mahasiswa/i</div>
                <div class="text-2xl font-bold">{{ $totalMahasiswa }}</div>
            </div>
        </div>
    </div>

    <div class="bg-green-200 p-4 rounded flex items-center justify-between">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-4xl text-green-600 mr-4"></i>
            <div>
                <div class="text-gray-600">Sudah Membayar</div>
                <div class="text-2xl font-bold">{{ $sudahMembayar }}</div>
            </div>
        </div>
    </div>

    <div class="bg-red-200 p-4 rounded flex items-center justify-between">
        <div class="flex items-center">
            <i class="fas fa-times-circle text-4xl text-red-600 mr-4"></i>
            <div>
                <div class="text-gray-600">Belum Membayar</div>
                <div class="text-2xl font-bold">{{ $belumMembayar }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Bar Chart -->
<div class="text-2xl font-bold mb-4">Distribusi Pembayaran</div>
<div class="bg-white p-4 rounded shadow">
    <canvas id="barChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('barChart').getContext('2d');
    const barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Sudah Membayar', 'Belum Membayar'],
            datasets: [{
                label: 'Distribusi Pembayaran',
                data: [{{ $sudahMembayar }}, {{ $belumMembayar }}],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 99, 132, 0.6)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Distribusi Pembayaran Mahasiswa',
                    font: {
                        size: 18
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
