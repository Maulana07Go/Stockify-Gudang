@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Manajemen Stok Minimum</h2>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.stock.index') }}" class="inline-block px-4 py-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700 transition duration-200">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="border p-3">#</th>
                    <th class="border p-3">Nama Barang</th>
                    <th class="border p-3">Stok Minimum</th>
                    <th class="border p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $index => $product)
                <tr class="text-center border">
                    <td class="border p-3">{{ $index + 1 }}</td>
                    <td class="border p-3">{{ $product->name }}</td>
                    <td class="border p-3">{{ $product->minimum_stock }}</td>
                    <td class="border p-3">
                        <a href="{{ route('admin.stock.minimum.edit', $product->id) }}" 
                           class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                            Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="border p-4 text-center text-gray-500">Tidak ada data stok minimum.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection