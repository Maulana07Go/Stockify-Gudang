@extends('layouts.staff')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Riwayat Transaksi Stok</h2>
        <div>
            <a href="{{ route('staff.stock.inconfirm.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Konfirmasi Penerimaan Barang
            </a>
            <a href="{{ route('staff.stock.outconfirm.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 ml-2">
                Konfirmasi Pengeluaran Barang
            </a>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
            <form method="GET" action="{{ route('staff.stock.index') }}" class="flex space-x-2">
                <input 
                    type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari transaksi..." 
                    class="border p-2 rounded"
                >
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Cari
                </button>
            </form>
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
                    <td class="border p-3">
                        <a href="{{ route('staff.stock.show', $transaction->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                            Lihat
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
        <div class="mt-4">
            {{ $transactions->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</div>
@endsection