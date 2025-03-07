@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Supplier</h2>

        <form action="{{ route('admin.supplier.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Nama Supplier</label>
                <input type="text" name="name" class="w-full border-gray-300 rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Alamat</label>
                <textarea name="address" class="w-full border-gray-300 rounded-lg p-2"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Nomor Telepon</label>
                <input type="text" name="phone" class="w-full border-gray-300 rounded-lg p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full border-gray-300 rounded-lg p-2">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Simpan
            </button>
            <a href="{{ route('admin.supplier.index') }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
        </form>
    </div>
</div>
@endsection