@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Kategori</h2>

        <form action="{{ route('admin.product.category.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Nama Kategori</label>
                <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Deskripsi</label>
                <textarea name="description" class="w-full p-2 border border-gray-300 rounded-lg"></textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Simpan
            </button>
            <a href="{{ route('admin.product.category.index') }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
        </form>
    </div>
</div>
@endsection