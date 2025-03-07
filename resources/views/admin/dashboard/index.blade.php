@extends('layouts.admin')

@section('content')
<div class="flex-1 p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
            
    <!-- Summary Cards -->
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-green-400 p-4 shadow rounded-lg flex items-center">
            <i class="fas fa-arrow-down text-3xl text-white mr-3"></i>
            <div>
                <h2 class="text-lg font-bold">Total Transaksi Masuk</h2>
                <p class="text-2xl font-semibold">{{ $transactionin }}</p>
            </div>
        </div>
        <div class="bg-red-400 p-4 shadow rounded-lg flex items-center">
            <i class="fas fa-arrow-up text-3xl text-white mr-3"></i>
            <div>
                <h2 class="text-lg font-bold">Total Transaksi Keluar</h2>
                <p class="text-2xl font-semibold">{{ $transactionout }}</p>
            </div>
        </div>
        <div class="bg-yellow-400 p-4 shadow rounded-lg flex items-center">
            <i class="fas fa-boxes text-3xl text-white mr-3"></i>
            <div>
                <h2 class="text-lg font-bold">Total Produk</h2>
                <p class="text-2xl font-semibold">{{ $totalProducts }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 mt-4">
        <div class="bg-green-400 p-4 shadow rounded-lg flex items-center">
            <i class="fas fa-calendar-day text-3xl text-white mr-3"></i>
            <div>
                <h2 class="text-lg font-bold">Transaksi Masuk Bulan Ini</h2>
                <p class="text-2xl font-semibold">{{ $inthismonth }}</p>
            </div>
        </div>
        <div class="bg-red-400 p-4 shadow rounded-lg flex items-center">
            <i class="fas fa-calendar-day text-3xl text-white mr-3"></i>
            <div>
                <h2 class="text-lg font-bold">Transaksi Keluar Bulan Ini</h2>
                <p class="text-2xl font-semibold">{{ $outthismonth }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 mt-4">
        <div class="bg-green-400 p-4 shadow rounded-lg flex items-center">
            <i class="fas fa-clock text-3xl text-white mr-3"></i>
            <div>
                <h2 class="text-lg font-bold">Transaksi Masuk Hari Ini</h2>
                <p class="text-2xl font-semibold">{{ $intoday }}</p>
            </div>
        </div>
        <div class="bg-red-400 p-4 shadow rounded-lg flex items-center">
            <i class="fas fa-clock text-3xl text-white mr-3"></i>
            <div>
                <h2 class="text-lg font-bold">Transaksi Keluar Hari Ini</h2>
                <p class="text-2xl font-semibold">{{ $outtoday }}</p>
            </div>
        </div>
    </div>

    <!-- Grafik Stok Gudang -->
    <div class="mt-6 bg-white p-4 shadow rounded-lg">
        <h2 class="text-lg font-bold mb-4">Grafik Stok Barang</h2>
        <canvas id="stockChart"></canvas>
    </div>

    <!-- Grafik Pergerakan Stok -->
    <div class="mt-6 bg-white p-4 shadow rounded-lg">
        <h2 class="text-lg font-bold mb-4">Grafik Pergerakan Stok</h2>
        <canvas id="stockMovementChart"></canvas>
    </div>
            
    <!-- Activity Table -->
    <div class="mt-6 bg-white p-4 shadow rounded-lg">
        <h2 class="text-lg font-bold mb-4">Aktivitas Terbaru</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">User</th>
                    <th class="border p-2">Aktivitas</th>
                    <th class="border p-2">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($useractivities->sortByDesc('created_at') as $index => $useractivity)
                <tr>
                    <td class="border p-2">{{ $usernames->firstWhere('id', $useractivity->user_id)->name ?? 'Tidak ditemukan' }}</td>
                    <td class="border p-2">{{ $useractivity->activity }}</td>
                    <td class="border p-2">{{ $useractivity->date }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="border p-4 text-center text-gray-500">Tidak ada aktivitas pengguna terbaru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $useractivities->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data untuk Stok Barang per Kategori
    var stockCategories = @json($stockData->pluck('category_name'));
    var stockValues = @json($stockData->pluck('total_stock'));

    var ctx = document.getElementById('stockChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: stockCategories,
            datasets: [{
                label: 'Jumlah Stok',
                data: stockValues,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Data untuk Pergerakan Stok
    var movementDates = @json($stockMovement->pluck('date'));
    var stockIn = @json($stockMovement->pluck('stock_in'));
    var stockOut = @json($stockMovement->pluck('stock_out'));

    var ctx2 = document.getElementById('stockMovementChart').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: movementDates,
            datasets: [
                {
                    label: 'Barang Masuk',
                    data: stockIn,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true
                },
                {
                    label: 'Barang Keluar',
                    data: stockOut,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

@endsection