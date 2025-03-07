@extends('layouts.admin')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Profil Admin</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Menampilkan Foto Profil -->
    <div class="flex flex-col items-center">
        <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/default-avatar.png') }}" 
             alt="Profile Photo" class="w-32 h-32 rounded-full mb-4 object-cover border border-gray-300">
        <p class="text-lg font-semibold">{{ $user->name }}</p>
        <p class="text-sm text-gray-500">{{ $user->email }}</p>
    </div>

    <!-- Form Update Profil -->
    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        <label class="block mb-2 text-sm font-medium text-gray-700">Nama</label>
        <input type="text" name="name" value="{{ $user->name }}" 
               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">

        <label class="block mt-4 mb-2 text-sm font-medium text-gray-700">Upload Foto Baru</label>
        <input type="file" name="photo" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">

        <button type="submit" class="mt-4 w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Update Profil
        </button>
    </form>
</div>
@endsection