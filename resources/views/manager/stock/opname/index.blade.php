@extends('layouts.manager')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Stok Opname</h2>

    <div class="mt-6">
        <a href="{{ route('manager.stock.index') }}" class="inline-block px-4 py-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700 transition duration-200">
            Kembali
        </a>
    </div>

    <!-- Tombol Tambah Stok Opname -->
    <div class="mb-4">
        <a href="{{ route('manager.stock.opname.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Buat Stok Opname
        </a>
    </div>

    <!-- Tabel Stok Opname -->
    <div class="bg-white shadow-lg rounded-lg p-6">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">#</th>
                    <th class="border p-2">Nama Barang</th>
                    <th class="border p-2">Stok Awal</th>
                    <th class="border p-2">Stok Akhir</th>
                    <th class="border p-2">Selisih</th>
                    <th class="border p-2">Catatan</th>
                    <th class="border p-2">Tanggal Opname</th>
                </tr>
            </thead>
            <tbody>
                @foreach($opnames as $index => $opname)
                <tr class="border-b">
                    <td class="border p-2">{{ $index + 1 }}</td>
                    <td class="border p-2">{{ $opname->product?->name ?? 'Tidak ada data produk' }}</td>
                    <td class="border p-2">{{ $opname->initial_stock }}</td>
                    <td class="border p-2">{{ $opname->final_stock }}</td>
                    <td class="border p-2 {{ $opname->difference < 0 ? 'text-red-600' : 'text-green-600' }}">
                        {{ $opname->difference }}
                    </td>
                    <td class="border p-2">{{ $opname->notes ?? '-' }}</td>
                    <td class="border p-2">{{ $opname->date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Jika Tidak Ada Data -->
        @if($opnames->isEmpty())
            <p class="text-center py-4">Belum ada data stok opname.</p>
        @endif
    </div>
</div>
@endsection