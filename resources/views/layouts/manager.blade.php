<!-- resources/views/layouts/manager.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Panel</title>
    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
        <!-- Fixed Header -->
        <header class="fixed top-0 left-0 right-0 bg-gray-800 text-white py-3 px-6 flex justify-between items-center z-50">
            <div class="flex items-center">
                @php
                    $setting = App\Models\Setting::first();
                    $logo = $setting ? $setting->logo : null;
                    $appName = $setting ? $setting->site_name : null;
                    $user = Auth::user();
                @endphp
                @if ($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-8 w-8 mr-2">
                @endif
                @if ($appName)
                <h2 class="text-xl font-bold">{{ $appName }}</h2>
                @endif
                <button id="toggleSidebar" class="bg-gray-800 px-4 py-2 rounded-lg hover:bg-gray-700">☰ Menu</button>
            </div>

            <!-- Foto Profil & Dropdown -->
            <div class="relative">
                <button id="profileDropdownButton" class="flex items-center space-x-2 focus:outline-none">
                    <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/default-avatar.png') }}" 
                        alt="Profile Photo" class="h-8 w-8 rounded-full border border-gray-300">
                    <span class="hidden md:inline">{{ $user->name }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white text-gray-800 shadow-lg rounded-lg overflow-hidden z-50">
                    <a href="{{ route('manager.profile.index') }}" class="block px-4 py-2 hover:bg-gray-100">Profil</a>
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </header>

    <div class="flex flex-1 pt-16"> <!-- Menyesuaikan agar tidak tertutup header -->
        <!-- Sidebar -->
        <div id="sidebar" class="fixed left-0 top-16 bottom-9 h-auto w-64 bg-gray-800 text-white flex flex-col p-5 transition-all duration-300">
            <h2 class="text-xl font-bold mb-6">Stockify</h2>
            <ul class="flex-1">
                <li class="mb-3">
                    <a href="{{ route('manager.dashboard.index') }}" class="block p-2 hover:bg-gray-700">
                    <i class="fas fa-home mr-3"></i>Dashboard
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('manager.product.index') }}" class="block p-2 hover:bg-gray-700">
                    <i class="fas fa-box mr-3"></i>Produk
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('manager.stock.index') }}" class="block p-2 hover:bg-gray-700">
                    <i class="fa-solid fa-cubes mr-3"></i>Stok
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('manager.supplier.index') }}" class="block p-2 hover:bg-gray-700">
                    <i class="fa-solid fa-truck-field mr-3"></i>Supplier
                    </a>
                </li>
                <li class="mb-3"><a href="{{ route('manager.report.index') }}" class="block p-2 hover:bg-gray-700"><i class="fa-solid fa-file mr-3"></i>Laporan</a></li>
            </ul>

        </div>

        <!-- Main Content -->
        <main id="mainContent" class="flex-1 p-5 ml-64 transition-all duration-300 overflow-auto pb-16">

            @yield('content')  <!-- Tempat untuk konten halaman -->
        </main>
    </div>

    <!-- Fixed Footer -->
    <footer class="fixed bottom-0 left-0 right-0 bg-gray-800 text-white py-2 text-center text-sm z-50">
        &copy; {{ date('Y') }} Stockify - All Rights Reserved
    </footer>

    <script>
        const sidebar = document.getElementById("sidebar");
        const mainContent = document.getElementById("mainContent");
        const toggleButton = document.getElementById("toggleSidebar");

        toggleButton.addEventListener("click", function () {
            sidebar.classList.toggle("-translate-x-full");

            if (sidebar.classList.contains("-translate-x-full")) {
                mainContent.classList.remove("ml-64");
                mainContent.classList.add("ml-0");
            } else {
                mainContent.classList.remove("ml-0");
                mainContent.classList.add("ml-64");
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
            const profileButton = document.getElementById("profileDropdownButton");
            const profileMenu = document.getElementById("profileDropdownMenu");

            profileButton.addEventListener("click", function () {
                profileMenu.classList.toggle("hidden");
            });

            document.addEventListener("click", function (event) {
                if (!profileButton.contains(event.target) && !profileMenu.contains(event.target)) {
                    profileMenu.classList.add("hidden");
                }
            });
        });
    </script>
</body>
</html>