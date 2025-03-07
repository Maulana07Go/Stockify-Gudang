@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <div class="flex gap-2">
            <a href="{{ route('admin.stock.opname.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Stock Opname
            </a>
            <a href="{{ route('admin.stock.minimum.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Stock Minimum
            </a>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold mb-4">Riwayat Transaksi Stok</h2>
            <form method="GET" action="{{ route('admin.stock.index') }}" class="flex space-x-2">
                <input 
                    type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari transaksi..." 
                    class="border p-2 rounded"
                >
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Cari
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="border p-3">#</th>
                        <th class="border p-3">Produk</th>
                        <th class="border p-3">Kode Barang</th> <!-- Kolom SKU baru -->
                        <th class="border p-3">User</th>
                        <th class="border p-3">Jenis Transaksi</th>
                        <th class="border p-3">Jumlah</th>
                        <th class="border p-3">Tanggal</th>
                        <th class="border p-3">Status</th>
                        <th class="border p-3">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $index => $transaction)
                    <tr class="text-center border">
                        <td class="border p-3">{{ $index + 1 }}</td>
                        <td class="border p-3">{{ $transaction->product?->name ?? 'Tidak ada data produk' }}</td>
                        <td class="border p-3">{{ $transaction->product?->sku ?? '-' }}</td> <!-- Menampilkan SKU -->
                        <td class="border p-3">{{ $transaction->user?->name ?? 'Tidak ada data user' }}</td>
                        <td class="border p-3">
                            <span class="px-2 py-1 rounded 
                                {{ $transaction->type == 'Masuk' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                {{ $transaction->type }}
                            </span>
                        </td>
                        <td class="border p-3">{{ $transaction->quantity }}</td>
                        <td class="border p-3">{{ $transaction->date }}</td>
                        <td class="border p-3">
                            <span class="px-2 py-1 rounded 
                                @if($transaction->status == 'Pending') bg-yellow-500 text-white 
                                @elseif($transaction->status == 'Diterima') bg-green-500 text-white 
                                @elseif($transaction->status == 'Ditolak') bg-red-500 text-white 
                                @else bg-blue-500 text-white @endif">
                                {{ $transaction->status }}
                            </span>
                        </td>
                        <td class="border p-3">{{ $transaction->notes ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="border p-4 text-center text-gray-500">Tidak ada transaksi stok tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
            {{ $transactions->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection