@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah User</h2>

        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-medium">Nama</label>
                <input type="text" name="name" class="w-full p-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Email</label>
                <input type="email" name="email" class="w-full p-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Role</label>
                <select name="role" class="w-full p-2 border rounded-lg" required>
                    <option value="Admin">Admin</option>
                    <option value="Staff Gudang">Staff Gudang</option>
                    <option value="Manajer Gudang">Manajer Gudang</option>
                </select>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('admin.user.index') }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection