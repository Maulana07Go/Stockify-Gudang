@extends('layouts.staff')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Konfirmasi Transaksi Masuk</h2>
    </div>

    <div class="mt-6">
        <a href="{{ route('staff.stock.index') }}" class="inline-block px-4 py-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700 transition duration-200">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="border p-3">#</th>
                    <th class="border p-3">Produk</th>
                    <th class="border p-3">Kode Barang</th>
                    <th class="border p-3">Tipe</th>
                    <th class="border p-3">Jumlah</th>
                    <th class="border p-3">Tanggal</th>
                    <th class="border p-3">Status</th>
                    <th class="border p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $index => $transaction)
                <tr class="text-center border">
                    <td class="border p-3">{{ $index + 1 }}</td>
                    <td class="border p-3">{{ $transaction->product?->name ?? 'Tidak ada data produk' }}</td>
                    <td class="border p-3">{{ $transaction->product?->sku ?? '-' }}</td>
                    <td class="border p-3">{{ $transaction->type }}</td>
                    <td class="border p-3">{{ $transaction->quantity }}</td>
                    <td class="border p-3">{{ $transaction->date }}</td>
                    <td class="border p-3">{{ $transaction->status }}</td>
                    <td class="border p-3">
                        <a href="{{ route('staff.stock.inconfirm.edit', $transaction->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                            Cek
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="border p-4 text-center text-gray-500">Tidak ada transaksi tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection