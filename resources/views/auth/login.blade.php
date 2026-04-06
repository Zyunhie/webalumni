{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Alumni / Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-green-700">Selamat Datang</h1>
            <p class="text-green-500 mt-2">Silakan masuk untuk melanjutkan</p>
        </div>

        {{-- Error umum --}}
        @if(session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- Error validasi --}}
        @error('login')
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                {{ $message }}
            </div>
        @enderror

        <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="login" class="block text-green-700 font-medium mb-1">
                    NIM
                </label>
                <input 
                    type="text" 
                    name="login" 
                    id="login" 
                    value="{{ old('login') }}"
                    required
                    class="w-full border border-green-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                    placeholder="Masukkan NIM">
            </div>

            <div>
                <label for="password" class="block text-green-700 font-medium mb-1">
                    Password
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required
                    class="w-full border border-green-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                    placeholder="Password awal = NIM">
            </div>

            <button 
                type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                Masuk
            </button>
        </form>
    </div>

</body>
</html>
