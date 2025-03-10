@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold">Edit Atribut Produk</h1>

        <div class="bg-white p-4 shadow rounded-lg mt-4">
            <form action="{{ route('admin.product.attribute.update', $attribute->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block font-bold">Nama Atribut:</label>
                    <input type="text" name="name" value="{{ $attribute->name }}" class="w-full border p-2 rounded-lg" required>
                </div>
                
                <div class="mb-4">
                    <label class="block font-bold">Nilai Atribut:</label>
                    <input type="text" name="value" value="{{ $attribute->value }}" class="w-full border p-2 rounded-lg" required>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Update Atribut
                </button>
            </form>
        </div>
    </div>
@endsection