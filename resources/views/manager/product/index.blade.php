@extends('layouts.manager')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Daftar Produk</h2>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Daftar Produk</h2>
            <form method="GET" action="{{ route('manager.product.index') }}" class="flex space-x-2">

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
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="border p-3">#</th>
                    <th class="border p-3">Nama Produk</th>
                    <th class="border p-3">Kode Barang</th>
                    <th class="border p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $index => $product)
                <tr class="text-center border">
                    <td class="border p-3">{{ $index + 1 }}</td>
                    <td class="border p-3">{{ $product->name }}</td>
                    <td class="border p-3">{{ $product->sku }}</td>
                    <td class="border p-3">
                        <a href="{{ route('manager.product.show', $product->id) }}" 
                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="border p-4 text-center text-gray-500">Tidak ada produk tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $products->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</div>
@endsection