{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Portal Alumni</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        h1 { font-family: 'Playfair Display', serif; }
        body { background-color: #f0f7f0; background-image: radial-gradient(ellipse at 20% 50%, rgba(34,103,54,0.08) 0%, transparent 60%), radial-gradient(ellipse at 80% 20%, rgba(34,103,54,0.06) 0%, transparent 50%); min-height: 100vh; }
        .card { box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 20px 60px -10px rgba(34,103,54,0.15), 0 0 0 1px rgba(34,103,54,0.06); animation: fadeUp 0.5s ease forwards; }
        .input-field { width: 100%; border: 1.5px solid #d1fae5; border-radius: 10px; padding: 11px 16px; font-size: 0.9rem; background: #f9fefb; color: #1a3a1a; transition: all 0.2s ease; outline: none; appearance: none; }
        .input-field::placeholder { color: #9ca3af; }
        .input-field:focus { border-color: #16a34a; background: #fff; box-shadow: 0 0 0 3px rgba(22,163,74,0.1); }
        .btn-primary { width: 100%; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; font-weight: 500; font-size: 0.95rem; padding: 12px; border-radius: 10px; border: none; cursor: pointer; transition: all 0.2s ease; }
        .btn-primary:hover { background: linear-gradient(135deg, #15803d 0%, #166534 100%); box-shadow: 0 4px 15px rgba(22,163,74,0.35); transform: translateY(-1px); }
        .logo-ring { width: 72px; height: 72px; border-radius: 50%; background: linear-gradient(135deg, #dcfce7, #f0fdf4); border: 2px solid #bbf7d0; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(22,163,74,0.15); }
        .badge { display: inline-flex; align-items: center; gap: 6px; background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; font-size: 0.7rem; font-weight: 500; letter-spacing: 0.06em; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; }
        .badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #22c55e; }
        .step-hint { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 10px 14px; font-size: 0.78rem; color: #15803d; line-height: 1.5; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen px-4 py-10">
    <div class="w-full max-w-sm">
        <div class="card bg-white rounded-2xl p-8">
            <div class="flex flex-col items-center mb-6">
                <div class="logo-ring mb-3">
                    <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="w-11 h-11 object-contain">
                </div>
                <span class="badge">Pendaftaran Alumni</span>
                <h1 class="text-2xl text-gray-800 mt-3 mb-1">Buat Akun</h1>
                <p class="text-gray-400 text-sm text-center">Isi data sesuai data kelulusan kamu</p>
            </div>

            <div class="step-hint mb-5">
                Pastikan NIM, nama, prodi, dan angkatan sesuai ijazah. Akun akan diverifikasi admin sebelum aktif.
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl mb-5">
                    @foreach($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="input-field" placeholder="Sesuai ijazah">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">NIM</label>
                    <input type="text" name="nim" value="{{ old('nim') }}" required class="input-field" placeholder="Nomor Induk Mahasiswa">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Program Studi</label>
                    <select name="prodi" required class="input-field">
                        <option value="" disabled {{ old('prodi') ? '' : 'selected' }}>Pilih Prodi</option>
                        @foreach(['PGMI','PAI','PIAUD','MPI','BKPI','Ekonomi Syariah','Hukum Keluarga Islam','Hukum Tata Negara','S2 PAI'] as $prodi)
                            <option value="{{ $prodi }}" {{ old('prodi') === $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Angkatan</label>
                    <select name="angkatan" required class="input-field">
                        <option value="" disabled {{ old('angkatan') ? '' : 'selected' }}>Pilih Angkatan</option>
                        @for($year = date('Y'); $year >= 2000; $year--)
                            <option value="{{ $year }}" {{ old('angkatan') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="input-field" placeholder="email@contoh.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Password</label>
                    <input type="password" name="password" required class="input-field" placeholder="Minimal 8 karakter">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="input-field" placeholder="Ulangi password">
                </div>
                <div class="pt-1">
                    <button type="submit" class="btn-primary">Daftar Sekarang</button>
                </div>
            </form>

            <p class="text-center text-sm text-gray-500 mt-5">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-green-600 font-medium hover:underline">Masuk di sini</a>
            </p>
        </div>
        <p class="text-center text-xs text-gray-400 mt-5">&copy; {{ date('Y') }} Portal Alumni</p>
    </div>
</body>
</html>