@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold">Detail Produk</h1>

        <div class="w-full h-64 flex justify-center items-center bg-gray-100 rounded-lg shadow">
            <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk" class="max-w-full max-h-full">
        </div>

        <div class="bg-white p-4 shadow rounded-lg mt-4">
            <p><strong>Nama:</strong> {{ $product->name }}</p>
            <p><strong>Kategori:</strong> {{ $product->category?->name ?? 'Tidak ada kategori' }}</p>
            <p><strong>Supplier:</strong> {{ $product->supplier?->name ?? 'Tidak ada supplier' }}</p>
            <p><strong>Harga Beli:</strong> Rp {{ number_format($product->purchase_price, 2) }}</p>
            <p><strong>Harga Jual:</strong> Rp {{ number_format($product->selling_price, 2) }}</p>
            <p><strong>SKU:</strong> {{ $product->sku }}</p>
            <p><strong>Deskripsi:</strong> {{ $product->description }}</p>
            <p><strong>Stok Minimum:</strong> {{ $product->minimum_stock }}</p>

            <a href="{{ route('admin.product.index') }}" class="bg-gray-500 text-white px-4 py-2 mt-3 inline-block">Kembali</a>
        </div>

        <!-- Daftar Atribut Produk -->
        <div class="bg-white p-4 shadow rounded-lg mt-4">
            <h2 class="text-xl font-bold">Atribut Produk</h2>

            @if ($product->attributes->isEmpty())
                <p class="text-gray-500">Tidak ada atribut yang tersedia.</p>
            @else
                <ul class="mt-2">
                    @foreach ($product->attributes as $attribute)
                        <li class="flex justify-between items-center border-b py-2">
                            <span>{{ $attribute->name }}: {{ $attribute->value }}</span>
                            <a href="{{ route('admin.product.attribute.edit', $attribute->id) }}" 
                               class="text-blue-500 hover:underline">Edit</a>
                        </li>
                    @endforeach
                </ul>
            @endif

            <a href="{{ route('admin.product.attribute.create', $product->id) }}" 
               class="mt-3 inline-block bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                + Tambah Atribut
            </a>
        </div>
    </div>
@endsection