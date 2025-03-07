@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Manajemen User</h2>
        <a href="{{ route('admin.user.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Tambah User
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Daftar Akun</h2>
            <form method="GET" action="{{ route('admin.user.index') }}" class="flex space-x-2">
                <input 
                    type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari pengguna..." 
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
                    <th class="border p-3">Email</th>
                    <th class="border p-3">Role</th>
                    <th class="border p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                <tr class="text-center border">
                    <td class="border p-3">{{ $index + 1 }}</td>
                    <td class="border p-3">{{ $user->name }}</td>
                    <td class="border p-3">{{ $user->email }}</td>
                    <td class="border p-3">{{ $user->role }}</td>
                    <td class="border p-3 space-x-2">
                        <a href="{{ route('admin.user.edit', $user->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                            Edit
                        </a>
                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user ini?');">
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
                    <td colspan="5" class="border p-4 text-center text-gray-500">Tidak ada user tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $users->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</div>
@endsection