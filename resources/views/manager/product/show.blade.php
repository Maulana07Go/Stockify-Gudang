@extends('layouts.manager')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Detail Produk</h2>

        <div class="grid grid-cols-2 gap-6">
            <div class="w-full h-64 flex justify-center items-center bg-gray-100 rounded-lg shadow">
                <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk" class="max-w-full max-h-full">
            </div>
            <div>
                <table class="w-full text-left">
                    <tr>
                        <th class="py-2 px-4 border">Nama Produk</th>
                        <td class="py-2 px-4 border">{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border">Kategori</th>
                        <td class="py-2 px-4 border">{{ $product->category?->name ?? 'Tidak ada kategori' }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border">Supplier</th>
                        <td class="py-2 px-4 border">{{ $product->supplier?->name ?? 'Tidak ada supplier' }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border">SKU</th>
                        <td class="py-2 px-4 border">{{ $product->sku }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border">Deskripsi</th>
                        <td class="py-2 px-4 border">{{ $product->description }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border">Harga Beli</th>
                        <td class="py-2 px-4 border">Rp {{ number_format($product->purchase_price, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border">Harga Jual</th>
                        <td class="py-2 px-4 border">Rp {{ number_format($product->selling_price, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border">Attribute Produk</th>
                        <td class="py-2 px-4 border">
                            @forelse ($product->attributes as $attribute)
                                <p>{{ $attribute->name }} : {{ $attribute->value }}</p>
                            @empty
                                Tidak ada atribut
                            @endforelse
                        </td>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border">Stok Minimum</th>
                        <td class="py-2 px-4 border">{{ $product->minimum_stock }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border">Reorder Point</th>
                        <td class="py-2 px-4 border">{{ $product->reorder_point }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border">Average Usage</th>
                        <td class="py-2 px-4 border">{{ $product->average_usage }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border">Average Lead Time</th>
                        <td class="py-2 px-4 border">{{ $product->average_lead_time }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('manager.product.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection