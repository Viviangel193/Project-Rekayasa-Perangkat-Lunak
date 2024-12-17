<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script>
        // Fungsi untuk mengganti warna latar belakang
        function changeBgColor(event) {
            document.body.style.background = event.target.value;
        }

        // Fungsi untuk toggle visibility password
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        // Fungsi untuk menampilkan nilai input username dan password
        function displayInputValues() {
            const username = document.getElementById('nama_pengguna').value;
            const password = document.getElementById('password').value;
            const resultDiv = document.getElementById('inputResult');
            resultDiv.textContent = `Username: ${username}, Password: ${password}`;
        }
    </script>
</head>

<body class="bg-gradient-to-r from-blue-900 to-blue-700 h-screen flex items-center justify-center">

    <!-- Color Picker for Background -->
    <div class="absolute top-5 right-5">
        <label for="colorPicker" class="text-white mr-2">Choose Background Color:</label>
        <input type="color" id="colorPicker" value="#1e40af" onchange="changeBgColor(event)" class="rounded border-none p-2">
    </div>

    <!-- Login Form -->
    <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-lg shadow-lg">
        <div class="flex justify-center mb-8">
            <img src="https://i.pinimg.com/enabled_lo_mid/736x/eb/ef/6d/ebef6ddbd46766e5d73acae546843e6f.jpg" alt="Logo" class="w-16 h-16">
        </div>
        <h2 class="text-center text-3xl font-extrabold text-gray-900">School!</h2>

        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        <form class="mt-7 space-y-4" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="nama_pengguna" class="sr-only">Username</label>
                    <div class="relative">
                        <input
                            type="text"
                            name="nama_pengguna"
                            id="nama_pengguna"
                            autocomplete="username"
                            class="appearance-none rounded-none relative block w-full px-10 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Username"
                            value="{{ old('nama_pengguna') }}"
                            required>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <label for="kata_sandi" class="sr-only">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="kata_sandi"
                            id="password"
                            autocomplete="current-password"
                            class="appearance-none rounded-none relative block w-full px-10 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Password"
                            required>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePasswordVisibility()">
                            <i id="eye-icon" class="fas fa-eye text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <button
                    type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Login
                </button>
            </div>
        </form>



    </div>
</body>

</html>
