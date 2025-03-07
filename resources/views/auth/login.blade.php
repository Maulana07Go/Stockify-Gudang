<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Login</h2>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <!-- Email Input -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" id="email" name="email"
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('email') border-red-500 @enderror"
                    placeholder="name@example.com" value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('password') border-red-500 @enderror"
                    placeholder="********">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Login
            </button>

            <!-- Link ke Register -->
            <p class="text-center text-sm text-gray-600 mt-4">
                Belum punya akun? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Daftar</a>
            </p>
        </form>
    </div>

</body>
</html>