@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Supplier</h2>

        <form action="{{ route('admin.supplier.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Nama Supplier</label>
                <input type="text" name="name" value="{{ $supplier->name }}" class="w-full border-gray-300 rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Alamat</label>
                <textarea name="address" class="w-full border-gray-300 rounded-lg p-2">{{ $supplier->address }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ $supplier->phone }}" class="w-full border-gray-300 rounded-lg p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" value="{{ $supplier->email }}" class="w-full border-gray-300 rounded-lg p-2">
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                Update
            </button>
            <a href="{{ route('admin.supplier.index') }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
        </form>
    </div>
</div>
@endsection