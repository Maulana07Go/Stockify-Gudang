@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Kategori</h2>

        <form action="{{ route('admin.product.category.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Nama Kategori</label>
                <input type="text" name="name" value="{{ $category->name }}" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Deskripsi</label>
                <textarea name="description" class="w-full p-2 border border-gray-300 rounded-lg">{{ $category->description }}</textarea>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                Perbarui
            </button>
            <a href="{{ route('admin.product.category.index') }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
        </form>
    </div>
</div>
@endsection