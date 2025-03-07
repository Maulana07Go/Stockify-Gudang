@extends('layouts.staff')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Dashboard Staff Gudang</h2>

    <!-- Grid Container -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Barang Masuk -->
        <div class="bg-green-300 shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-3">Barang Masuk yang Perlu Diperiksa</h3>
            @if($incomingStocks->isEmpty())
                <p class="text-gray-500">Tidak ada barang masuk yang perlu diperiksa.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($incomingStocks as $stock)
                        <li class="py-2 flex justify-between items-center">
                            <span>{{ $stock->product->name }} ({{ $stock->quantity }} unit)</span>
                            <a href="{{ route('staff.stock.inconfirm.edit', $stock->id) }}" 
                               class="text-blue-500 hover:text-blue-700 text-sm">Detail</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Barang Keluar -->
        <div class="bg-red-300 shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-3">Barang Keluar yang Perlu Disiapkan</h3>
            @if($outgoingStocks->isEmpty())
                <p class="text-gray-500">Tidak ada barang keluar yang perlu disiapkan.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($outgoingStocks as $stock)
                        <li class="py-2 flex justify-between items-center">
                            <span>{{ $stock->product->name }} ({{ $stock->quantity }} unit)</span>
                            <a href="{{ route('staff.stock.outconfirm.edit', $stock->id) }}" 
                               class="text-blue-500 hover:text-blue-700 text-sm">Siapkan</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection