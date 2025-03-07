<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
</head>
<body class="flex flex-col min-h-screen bg-gray-100">

    <!-- HEADER -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <h1 class="text-2xl font-bold text-gray-800">Stockify</h1>
            <div>
                <a href="{{ route('login') }}" class="px-4 py-2 text-blue-500 hover:text-blue-600">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Register</a>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <main class="flex-grow flex items-center justify-center text-center px-6">
        <div>
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Selamat Datang di Stockify</h2>
            <p class="text-gray-600 text-lg mb-6">Aplikasi terbaik untuk mengelola gudang Anda dengan mudah.</p>
            <a href="{{ route('register') }}" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Daftar Sekarang</a>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-800 text-white text-center py-4 mt-auto">
        <p>&copy; {{ date('Y') }} MyApp. Semua Hak Dilindungi.</p>
    </footer>

</body>
</html>