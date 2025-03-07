@extends('layouts.staff')

@section('content')
<div class="max-w-3xl mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Konfirmasi Transaksi Stok</h2>

    <form action="{{ route('staff.stock.inconfirm.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')

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
                        <th class="bg-gray-100 px-4 py-2 text-left">Atribut</th>
                        <td class="px-4 py-2">
                            @forelse ($transaction->product->attributes as $attribute)
                                <p>{{ $attribute->name }} : {{ $attribute->value }}</p>
                            @empty
                                <p>Tidak ada atribut</p>
                            @endforelse
                        </td>
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


        <div class="mb-4">
            <label for="status" class="block text-gray-700 font-medium">Status</label>
            <select id="status" name="status" class="w-full p-2 border rounded-lg">
                <option value="Diterima" {{ $transaction->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="Ditolak" {{ $transaction->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="notes" class="block text-gray-700 font-medium">Catatan</label>
            <textarea id="notes" name="notes" class="w-full p-2 border rounded-lg">{{ $transaction->notes }}</textarea>
        </div>

        <div class="flex justify-between">
            <a href="{{ session('previous_url', route('staff.stock.inconfirm.index')) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection