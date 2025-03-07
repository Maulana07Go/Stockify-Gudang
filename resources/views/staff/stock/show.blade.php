@extends('layouts.staff')

@section('content')
<div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Detail Transaksi Stok</h2>

    <div class="border rounded-lg overflow-hidden">
        <table class="w-full border-collapse">
            <tbody>
                <tr class="border-b">
                    <th class="bg-gray-100 px-4 py-2 text-left w-1/3">ID Transaksi</th>
                    <td class="px-4 py-2">{{ $transaction->id }}</td>
                </tr>
                <tr class="border-b">
                    <th class="bg-gray-100 px-4 py-2 text-left">Produk</th>
                    <td class="px-4 py-2">{{ $transaction->product->name }}</td>
                </tr>
                <tr class="border-b">
                    <th class="bg-gray-100 px-4 py-2 text-left">User</th>
                    <td class="px-4 py-2">{{ $transaction->user->name }}</td>
                </tr>
                <tr class="border-b">
                    <th class="bg-gray-100 px-4 py-2 text-left">Jenis Transaksi</th>
                    <td class="px-4 py-2">{{ $transaction->type }}</td>
                </tr>
                <tr class="border-b">
                    <th class="bg-gray-100 px-4 py-2 text-left">Jumlah</th>
                    <td class="px-4 py-2">{{ $transaction->quantity }}</td>
                </tr>
                <tr class="border-b">
                    <th class="bg-gray-100 px-4 py-2 text-left">Tanggal</th>
                    <td class="px-4 py-2">{{ $transaction->date }}</td>
                </tr>
                <tr class="border-b">
                    <th class="bg-gray-100 px-4 py-2 text-left">Status</th>
                    <td class="px-4 py-2">
                        <span class="px-3 py-1 rounded-lg text-white 
                            {{ $transaction->status === 'Diterima' ? 'bg-green-500' : ($transaction->status === 'Ditolak' ? 'bg-red-500' : 'bg-gray-500') }}">
                            {{ $transaction->status }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th class="bg-gray-100 px-4 py-2 text-left">Catatan</th>
                    <td class="px-4 py-2">{{ $transaction->notes ?? 'Tidak ada catatan' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('staff.stock.index') }}" class="inline-block px-4 py-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700 transition duration-200">
            Kembali
        </a>
    </div>
</div>
@endsection