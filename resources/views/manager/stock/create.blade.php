@extends('layouts.manager')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Buat Transaksi Stok Baru</h2>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <form action="{{ route('manager.stock.store') }}" method="POST">
            @csrf
            
            <!-- Pilih Produk -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="product_id">Pilih Produk</label>
                <select name="product_id" id="product_id" required class="w-full border-gray-300 rounded-lg p-2">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Jenis Transaksi -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Jenis Transaksi</label>
                <select name="type" required class="w-full border-gray-300 rounded-lg p-2">
                    <option value="Masuk">Barang Masuk</option>
                    <option value="Keluar">Barang Keluar</option>
                </select>
            </div>

            <!-- Jumlah -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="quantity">Jumlah</label>
                <input type="number" name="quantity" required min="1" class="w-full border-gray-300 rounded-lg p-2">
            </div>

            <!-- Catatan -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="notes">Catatan</label>
                <textarea name="notes" class="w-full border-gray-300 rounded-lg p-2" rows="3"></textarea>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-start">
                <a href="{{ route('manager.stock.index') }}" class="inline-block px-4 py-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700 transition duration-200">
                    Kembali
                </a>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection