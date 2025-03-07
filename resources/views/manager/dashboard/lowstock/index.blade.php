@extends('layouts.manager')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Barang Dengan Stok Rendah</h2>
    </div>

    <div class="mt-6">
        <a href="{{ route('manager.dashboard.index') }}" class="inline-block px-4 py-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700 transition duration-200">
                Kembali
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="border p-3">#</th>
                    <th class="border p-3">Nama</th>
                    <th class="border p-3">Stok</th>
                    <th class="border p-3">Minimum Stok</th>
                    <th class="border p-3">Waktu Pengiriman Masuk Barang</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lowproducts as $index => $lowproduct)
                <tr class="text-center border">
                    <td class="border p-3">{{ $index + 1 }}</td>
                    <td class="border p-3">{{ $lowproduct->name }}</td>
                    <td class="border p-3">{{ $lowproduct->stock }}</td>
                    <td class="border p-3">{{ $lowproduct->minimum_stock }}</td>
                    <td class="border p-3">{{ $lowproduct->average_lead_time }} hari</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="border p-4 text-center text-gray-500">Tidak ada produk yang memiliki stok rendah.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection