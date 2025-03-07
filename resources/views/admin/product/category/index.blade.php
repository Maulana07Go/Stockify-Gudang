@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Manajemen Kategori</h2>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.product.index') }}" class="inline-block px-4 py-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700 transition duration-200">
            Kembali
        </a>
    </div>

    {{-- Bagian Kategori --}}
    <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
        <h3 class="text-lg font-semibold mb-3">Daftar Kategori</h3>
        <div class="flex justify-end mb-2">
            <a href="{{ route('admin.product.category.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                + Tambah Kategori
            </a>
        </div>
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="border p-3">#</th>
                    <th class="border p-3">Nama Kategori</th>
                    <th class="border p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $index => $category)
                <tr class="text-center border">
                    <td class="border p-3">{{ $index + 1 }}</td>
                    <td class="border p-3">{{ $category->name }}</td>
                    <td class="border p-3 space-x-2">
                        <a href="{{ route('admin.product.category.edit', $category->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                            Edit
                        </a>
                        <form action="{{ route('admin.product.category.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="border p-4 text-center text-gray-500">Tidak ada kategori tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection