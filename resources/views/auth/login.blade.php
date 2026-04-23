{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Portal Alumni</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        h1 { font-family: 'Playfair Display', serif; }
        body { background-color: #f0f7f0; background-image: radial-gradient(ellipse at 20% 50%, rgba(34,103,54,0.08) 0%, transparent 60%), radial-gradient(ellipse at 80% 20%, rgba(34,103,54,0.06) 0%, transparent 50%); min-height: 100vh; }
        .card { box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 20px 60px -10px rgba(34,103,54,0.15), 0 0 0 1px rgba(34,103,54,0.06); animation: fadeUp 0.5s ease forwards; }
        .input-field { width: 100%; border: 1.5px solid #d1fae5; border-radius: 10px; padding: 11px 16px; font-size: 0.9rem; background: #f9fefb; color: #1a3a1a; transition: all 0.2s ease; outline: none; }
        .input-field::placeholder { color: #9ca3af; }
        .input-field:focus { border-color: #16a34a; background: #fff; box-shadow: 0 0 0 3px rgba(22,163,74,0.1); }
        .btn-primary { width: 100%; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; font-weight: 500; font-size: 0.95rem; padding: 12px; border-radius: 10px; border: none; cursor: pointer; transition: all 0.2s ease; }
        .btn-primary:hover { background: linear-gradient(135deg, #15803d 0%, #166534 100%); box-shadow: 0 4px 15px rgba(22,163,74,0.35); transform: translateY(-1px); }
        .logo-ring { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #dcfce7, #f0fdf4); border: 2px solid #bbf7d0; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(22,163,74,0.15); }
        .badge { display: inline-flex; align-items: center; gap: 6px; background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; font-size: 0.7rem; font-weight: 500; letter-spacing: 0.06em; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; }
        .badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #22c55e; }
        .divider { display: flex; align-items: center; gap: 12px; color: #9ca3af; font-size: 0.75rem; letter-spacing: 0.08em; text-transform: uppercase; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #e5e7eb; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen px-4 py-10">
    <div class="w-full max-w-sm">
        <div class="card bg-white rounded-2xl p-8">
            <div class="flex flex-col items-center mb-7">
                <div class="logo-ring mb-4">
                    <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="w-12 h-12 object-contain">
                </div>
                <span class="badge">Portal Alumni</span>
                <h1 class="text-2xl text-gray-800 mt-3 mb-1">Selamat Datang</h1>
                <p class="text-gray-400 text-sm text-center">Masuk menggunakan NIM atau nama akun kamu</p>
            </div>

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl mb-5">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-600 text-sm px-4 py-3 rounded-xl mb-5">{{ session('success') }}</div>
            @endif
            @error('login')
                <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl mb-5">{{ $message }}</div>
            @enderror

            <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">NIM / Nama</label>
                    <input type="text" name="login" value="{{ old('login') }}" required class="input-field" placeholder="Masukkan NIM atau nama">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Password</label>
                    <input type="password" name="password" required class="input-field" placeholder="Password kamu">
                </div>
                <div class="pt-1">
                    <button type="submit" class="btn-primary">Masuk</button>
                </div>
            </form>

            <div class="divider my-6">atau</div>

            <p class="text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-green-600 font-medium hover:underline">Daftar sekarang</a>
            </p>
        </div>
        <p class="text-center text-xs text-gray-400 mt-5">&copy; {{ date('Y') }} Portal Alumni</p>
    </div>
</body>
</html>