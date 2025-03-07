<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Aktivasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white p-6 rounded-lg shadow-md text-center w-96">
        <h1 class="text-2xl font-bold text-gray-800">Akun Anda Belum Aktif</h1>
        <p class="text-gray-600 mt-2">Silahkan tunggu admin untuk mengaktifkan akun Anda.</p>
        <div class="mt-4">
            <svg class="mx-auto w-16 h-16 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M4.93 19.07a10 10 0 1114.14 0M12 2a10 10 0 00-10 10 10 10 0 0010 10 10 10 0 0010-10A10 10 0 0012 2z" />
            </svg>
        </div>
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</body>
</html>
