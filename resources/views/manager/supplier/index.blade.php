@extends('layouts.manager')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Daftar Supplier</h2>
        <form method="GET" action="{{ route('manager.supplier.index') }}" class="flex space-x-2">
            <input 
                type="text" name="search" value="{{ request('search') }}" 
                placeholder="Cari supplier..." 
                class="border p-2 rounded"
            >
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Cari
            </button>
        </form>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="border p-3">#</th>
                    <th class="border p-3">Nama</th>
                    <th class="border p-3">Alamat</th>
                    <th class="border p-3">Telepon</th>
                    <th class="border p-3">Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $index => $supplier)
                <tr class="text-center border">
                    <td class="border p-3">{{ $index + 1 }}</td>
                    <td class="border p-3">{{ $supplier->name }}</td>
                    <td class="border p-3">{{ $supplier->address }}</td>
                    <td class="border p-3">{{ $supplier->phone }}</td>
                    <td class="border p-3">{{ $supplier->email }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="border p-4 text-center text-gray-500">Belum ada data supplier.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $suppliers->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</div>
@endsection