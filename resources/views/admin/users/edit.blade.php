@extends('layouts.app')

@section('content')
<section class="max-w-2xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit User</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="bg-white rounded-xl shadow-md p-6 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">NIM (Opsional - untuk alumni)</label>
            <input type="text" name="nim" value="{{ old('nim', $user->nim) }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Role</label>
            <select name="role" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User Biasa</option>
                <option value="alumni" {{ old('role', $user->role) == 'alumni' ? 'selected' : '' }}>Alumni</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Password Baru</label>
            <input type="password" name="password" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:underline">← Kembali</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg">
                Update
            </button>
        </div>
    </form>
</section>
@endsection

