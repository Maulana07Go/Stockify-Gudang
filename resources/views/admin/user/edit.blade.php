@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Edit User</h2>

        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium">Nama</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full p-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full p-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Password (Kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="w-full p-2 border rounded-lg">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Role</label>
                <select name="role" class="w-full p-2 border rounded-lg" required>
                    <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Staff Gudang" {{ $user->role == 'Staff Gudang' ? 'selected' : '' }}>Staff Gudang</option>
                    <option value="Manajer Gudang" {{ $user->role == 'Manajer Gudang' ? 'selected' : '' }}>Manajer Gudang</option>
                </select>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                    Perbarui
                </button>
                <a href="{{ route('admin.user.index') }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection