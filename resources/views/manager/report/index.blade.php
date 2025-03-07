@extends('layouts.manager')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Laporan</h2>
    </div>

    <!-- Form Filter -->
    <form method="GET" action="{{ route('manager.report.index') }}" class="bg-white shadow-lg rounded-lg p-4 mb-4">

        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
        <input type="hidden" name="search" value="{{ request('search') }}">

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

            <!-- Dropdown untuk memilih filter -->
            <div class="mt-4">
                <label class="block font-medium">Tipe</label>
                <select id="filterSelector" name="filter_type" class="w-full border rounded-lg p-2">
                    <option value="">Pilih Tipe</option>
                    <option value="year" {{ request('filter_type') == 'year' ? 'selected' : '' }}>Tahun</option>
                    <option value="month" {{ request('filter_type') == 'month' ? 'selected' : '' }}>Bulan</option>
                    <option value="day" {{ request('filter_type') == 'day' ? 'selected' : '' }}>Tanggal</option>
                </select>
            </div>
        
            <!-- Dropdown Tahun Awal -->
            <div id="yearStartInput" class="hidden mt-4">
                <label class="block font-medium">Tahun Awal</label>
                <select name="year_start" class="w-full border rounded-lg p-2">
                    <option value="">Pilih Tahun</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('year_start') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Dropdown Tahun Akhir -->
            <div id="yearEndInput" class="hidden mt-4">
                <label class="block font-medium">Tahun Akhir</label>
                <select name="year_end" class="w-full border rounded-lg p-2">
                    <option value="">Pilih Tahun</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('year_end') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Dropdown Bulan Awal -->
            <div id="monthStartInput" class="hidden mt-4">
                <label class="block font-medium">Bulan Awal</label>
                <select name="month_start" class="w-full border rounded-lg p-2">
                    <option value="">Pilih Bulan</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('month_start') == $i ? 'selected' : '' }}>{{ date("F", mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </select>
            </div>

            <!-- Dropdown Bulan Akhir -->
            <div id="monthEndInput" class="hidden mt-4">
                <label class="block font-medium">Bulan Akhir</label>
                <select name="month_end" class="w-full border rounded-lg p-2">
                    <option value="">Pilih Bulan</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('month_end') == $i ? 'selected' : '' }}>{{ date("F", mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </select>
            </div>

            <!-- Input Tanggal Awal-->
            <div id="dayStartInput" class="hidden mt-4">
                <label class="block font-medium">Tanggal Awal</label>
                <input type="date" name="date_start" class="w-full border rounded-lg p-2" value="{{ request('date_start') }}">
            </div>

            <!-- Input Tanggal Akhir-->
            <div id="dayEndInput" class="hidden mt-4">
                <label class="block font-medium">Tanggal Akhir</label>
                <input type="date" name="date_end" class="w-full border rounded-lg p-2" value="{{ request('date_end') }}">
            </div>
        </div>

        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Filter</button>
    </form>

    <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Laporan Stok</h2>
            <form method="GET" action="{{ route('manager.report.index') }}" class="flex space-x-2">

            <input type="hidden" name="filter_type" value="{{ request('filter_type') }}">
            <input type="hidden" name="year_start" value="{{ request('year_start') }}">
            <input type="hidden" name="year_end" value="{{ request('year_end') }}">
            <input type="hidden" name="month_start" value="{{ request('month_start') }}">
            <input type="hidden" name="month_end" value="{{ request('month_end') }}">
            <input type="hidden" name="day_start" value="{{ request('day_start') }}">
            <input type="hidden" name="day_end" value="{{ request('day_end') }}">

                <select name="category_id" class="border p-2 rounded">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <input 
                    type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari product..." 
                    class="border p-2 rounded"
                >
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Cari
                </button>
            </form>
        </div>
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="border p-3">#</th>
                    <th class="border p-3">Kode Barang</th>
                    <th class="border p-3">Nama Barang</th>
                    <th class="border p-3">Harga Beli</th>
                    <th class="border p-3">Harga Jual</th>
                    <th class="border p-3">Stok Awal</th>
                    <th class="border p-3">Barang Masuk</th>
                    <th class="border p-3">Barang Keluar</th>
                    <th class="border p-3">Stok Akhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $index => $product)
                <tr class="text-center border">
                    <td class="border p-3">{{ $index + 1 }}</td>
                    <td class="border p-3">{{ $product->sku }}</td>
                    <td class="border p-3">{{ $product->name }}</td>
                    <td class="border p-3">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                    <td class="border p-3">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                    <td class="border p-3">{{ number_format($stockAwal[$product->id] ?? 0, 0, ',', '.') }}</td>
                    <td class="border p-3">{{ number_format($totalStockMasuk[$product->id] ?? 0, 0, ',', '.') }}</td>
                    <td class="border p-3">{{ number_format($totalStockKeluar[$product->id] ?? 0, 0, ',', '.') }}</td>
                    <td class="border p-3">{{ number_format($stockAkhir[$product->id] ?? $product->stock, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="border p-4 text-center text-gray-500">Belum ada data stok.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $products->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let filterSelector = document.getElementById('filterSelector');
        let selectedValue = filterSelector.value || "{{ request('filter_type') }}"; // Ambil dari request jika ada

        function showFilter(selectedValue) {
            let filters = {
                year: ['yearStartInput', 'yearEndInput'],
                month: ['yearStartInput', 'yearEndInput', 'monthStartInput', 'monthEndInput'],
                day: ['dayStartInput', 'dayEndInput']
            };

            // Sembunyikan semua input
            document.querySelectorAll('[id$="Input"]').forEach(el => el.classList.add('hidden'));

            // Tampilkan yang sesuai dengan pilihan
            if (filters[selectedValue]) {
                filters[selectedValue].forEach(id => document.getElementById(id).classList.remove('hidden'));
            }
        }

        // Jalankan saat halaman dimuat
        showFilter(selectedValue);

        // Tambahkan event listener untuk perubahan dropdown
        filterSelector.addEventListener('change', function () {
            showFilter(this.value);
        });
    });
</script>
@endsection