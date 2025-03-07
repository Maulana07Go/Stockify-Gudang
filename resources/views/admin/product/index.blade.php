@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Manajemen Produk</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.product.category.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Kategori
            </a>
        </div>
    </div>

    {{-- Bagian Produk --}}
    <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Daftar Produk</h2>
            <form method="GET" action="{{ route('admin.product.index') }}" class="flex space-x-2">

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
                    placeholder="Cari produk..." 
                    class="border p-2 rounded"
                >
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Cari
                </button>
            </form>
        </div>
        <div class="flex justify-end mb-2">
            <a href="{{ route('admin.product.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                + Tambah Produk
            </a>
        </div>
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="border p-3">#</th>
                    <th class="border p-3">Nama</th>
                    <th class="border p-3">Kode Barang</th>
                    <th class="border p-3">Harga Jual</th>
                    <th class="border p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $index => $product)
                <tr class="text-center border">
                    <td class="border p-3">{{ $index + 1 }}</td>
                    <td class="border p-3">{{ $product->name }}</td>
                    <td class="border p-3">{{ $product->sku }}</td>
                    <td class="border p-3">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                    <td class="border p-3 space-x-2">
                        <a href="{{ route('admin.product.show', $product->id) }}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                            Lihat
                        </a>
                        <a href="{{ route('admin.product.edit', $product->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                            Edit
                        </a>
                        <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="border p-4 text-center text-gray-500">Tidak ada produk tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $products->appends(['search' => request('search')])->links() }}
        </div>
        <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
            {{-- Form Import CSV --}}
            <form action="{{ route('admin.product.importCsv') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                @csrf
                <input type="file" name="csv_file" required class="border rounded-lg px-3 py-2 text-sm">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Import CSV
                </button>
            </form>

            {{-- Tombol Export CSV --}}
            <a href="{{ route('admin.product.exportCsv') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-green-700 transition">
                <i class="fa fa-download"></i>
                <span>Export CSV</span>
            </a>
        </div>
    </div>
</div>
@endsection