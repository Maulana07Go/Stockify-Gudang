@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold">Tambah Produk</h1>

        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 shadow rounded-lg mt-4">
            @csrf

            <label class="block mt-2">Nama Produk:</label>
            <input type="text" name="name" class="border p-2 w-full" required>

            <label class="block mt-2">Kategori:</label>
            <select name="category_id" class="border p-2 w-full" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <label class="block mt-2">Supplier:</label>
            <select name="supplier_id" class="border p-2 w-full" required>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>

            <label class="block mt-2">Harga Beli:</label>
            <input type="number" name="purchase_price" class="border p-2 w-full" required>

            <label class="block mt-2">Harga Jual:</label>
            <input type="number" name="selling_price" class="border p-2 w-full" required>

            <label class="block mt-2">SKU:</label>
            <input type="text" name="sku" class="border p-2 w-full" required>

            <label class="block mt-2">Deskripsi:</label>
            <textarea name="description" class="border p-2 w-full"></textarea>

            <label class="block mt-2">Gambar Produk:</label>
            <input type="file" name="image" class="border p-2 w-full">

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-3">Simpan</button>
        </form>
        <div class="mt-6">
            <a href="{{ route('admin.product.index') }}" class="inline-block px-4 py-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700 transition duration-200">
                Kembali
            </a>
        </div>
    </div>
@endsection