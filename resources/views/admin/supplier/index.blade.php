@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Manajemen Supplier</h2>
        <a href="{{ route('admin.supplier.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Tambah Supplier
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Daftar Supplier</h2>
            <form method="GET" action="{{ route('admin.supplier.index') }}" class="flex space-x-2">
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
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="border p-3">#</th>
                    <th class="border p-3">Nama</th>
                    <th class="border p-3">Alamat</th>
                    <th class="border p-3">Telepon</th>
                    <th class="border p-3">Email</th>
                    <th class="border p-3">Aksi</th>
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
                    <td class="border p-3 space-x-2">
                        <a href="{{ route('admin.supplier.edit', $supplier->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                        <form action="{{ route('admin.supplier.destroy', $supplier->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus supplier ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</button>
                        </form>
                    </td>
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