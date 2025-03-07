@extends('layouts.manager')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Dashboard Manajer Gudang</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Stok Menipis -->
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
            <h3 class="font-bold">Stok Menipis</h3>
            <p class="text-lg">terdapat {{ $totallowproducts }} produk dengan stok menipis</p>
            <a href="{{ route('manager.dashboard.lowstock.index') }}" class="text-blue-500">Lihat Detail</a>
        </div>

        <!-- Barang Masuk Hari Ini -->
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
            <h3 class="font-bold">Barang Masuk Hari Ini</h3>
            <p class="text-lg">terdapat {{ $intoday }} transaksi barang masuk</p>
            <a href="{{ route('manager.dashboard.intoday.index') }}" class="text-blue-500">Lihat Detail</a>
        </div>

        <!-- Barang Keluar Hari Ini -->
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
            <h3 class="font-bold">Barang Keluar Hari Ini</h3>
            <p class="text-lg">terdapat {{ $outtoday }} transaksi barang keluar</p>
            <a href="{{ route('manager.dashboard.outtoday.index') }}" class="text-blue-500">Lihat Detail</a>
        </div>
    </div>
</div>
@endsection