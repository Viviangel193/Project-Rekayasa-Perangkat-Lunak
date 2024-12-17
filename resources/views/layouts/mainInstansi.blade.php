<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Instansi')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
</head>
<body class="font-roboto bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-1/5 bg-blue-800 text-white min-h-screen p-4">
            <div class="text-2xl font-bold mb-8">
                <img src="https://i.pinimg.com/enabled_lo_mid/736x/eb/ef/6d/ebef6ddbd46766e5d73acae546843e6f.jpg" alt="Logo" class="w-16 h-16">
            </div>
            <div class="mb-8">
                <div class="text-lg font-semibold mb-4">MENU</div>
                <ul>
                    <li class="mb-4">
                    <a class="flex items-center p-2 {{ request()->routeIs('instansi.home') ? 'bg-blue-600' : '' }} rounded" href="{{ route('instansi.home') }}">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="mb-4">
                    <a class="flex items-center p-2 {{ request()->routeIs('instansi.dataTrx') ? 'bg-blue-600' : '' }} rounded" href="{{ route('instansi.dataTrx') }}">
                            <i class="fas fa-exchange-alt mr-2"></i> Data Transaksi
                        </a>
                    </li>
                    <li class="mb-4">
                    <a class="flex items-center p-2 {{ request()->routeIs('instansi.man_pem') ? 'bg-blue-600' : '' }} rounded" href="{{ route('instansi.man_pem') }}">
                            <i class="fas fa-cogs mr-2"></i> Manajemen Pembayaran
                        </a>
                    </li>
                    <li class="mb-4">
                    <a class="flex items-center p-2 {{ request()->routeIs('instansi.mhs') ? 'bg-blue-600' : '' }} rounded" href="{{ route('instansi.mhs') }}">
                            <i class="fas fa-user-plus mr-2"></i> Tambah Data Mahasiswa
                        </a>
                    </li>
                    </li>
                    <!-- Tambahkan Data Pembayaran -->
                    <li class="mb-4">
                        <a class="flex items-center p-2 {{ request()->routeIs('instansi.instansi.databyr') ? 'bg-blue-600' : '' }} rounded" href="{{ route('instansi.instansi.databyr') }}">
                            <i class="fas fa-credit-card mr-2"></i>Data Pembayaran
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <div class="text-lg font-semibold mb-4">ADMINISTRATOR</div>
                <ul>
                    <li class="mb-4">
                        <a class="flex items-center p-2" href="#">
                            <i class="fas fa-user mr-2"></i> Admin01
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Main Content -->
        <div class="w-4/5">
            <!-- Header -->
            <div class="flex justify-between items-center bg-gray-200 p-4 shadow">
            <div class="text-3xl font-bold">@yield('title', 'Dashboard')</div>
                <div class="flex items-center">

                  <button type="submit" class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-4" onclick="window.location.href='/'">
                      Logout
                  </button>
                    <div class="flex items-center">
                        <img alt="Admin profile picture" class="rounded-full mr-2" height="40" src="https://via.placeholder.com/40" width="40" />
                        <span>Admin Instansi</span>
                    </div>
                </div>
            </div>
            <!-- Dynamic Content -->
            <div class="p-8">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
