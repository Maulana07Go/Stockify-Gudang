@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Pengaturan Aplikasi</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.setting.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Nama Aplikasi -->
        <div class="mb-4">
            <label for="site_name" class="block text-gray-700 font-semibold">Nama Aplikasi</label>
            <input type="text" id="site_name" name="site_name" class="w-full p-2 border rounded" value="{{ $setting->site_name ?? '' }}" required>
        </div>

        <!-- Logo Aplikasi -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Logo Aplikasi</label>
            @if (optional($setting)->logo)
                <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo Aplikasi" class="h-20 w-auto mb-3">
            @else
                <p class="text-gray-500">Belum ada logo</p>
            @endif
            <input type="file" name="logo" class="w-full p-2 border rounded">
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection