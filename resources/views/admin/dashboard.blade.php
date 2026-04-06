@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-green-700">
        Dashboard Admin
    </h1>

    <p class="mt-2 text-gray-600">
        Selamat datang, {{ auth()->user()->name }} 👋
    </p>

    <!-- Menu Admin -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <!-- Kelola User -->
        <a href="{{ route('admin.users.index') }}" class="block bg-blue-500 hover:bg-blue-600 text-white p-6 rounded-lg shadow transition">
            <div class="flex items-center gap-4">
                <div class="text-3xl">👥</div>
                <div>
                    <h3 class="font-bold text-lg">Kelola User</h3>
                    <p class="text-sm text-blue-100">Manage user yang bisa login</p>
                </div>
            </div>
        </a>

        <!-- Alumni Pending -->
        <a href="{{ route('admin.alumni.pending') }}" class="block bg-yellow-500 hover:bg-yellow-600 text-white p-6 rounded-lg shadow transition">
            <div class="flex items-center gap-4">
                <div class="text-3xl">⏳</div>
                <div>
                    <h3 class="font-bold text-lg">Alumni Pending</h3>
                    <p class="text-sm text-yellow-100">Verifikasi data alumni baru</p>
                </div>
            </div>
        </a>

        <!-- Kelola Alumni -->
        <a href="{{ route('alumni.s1.pgmi.index') }}" class="block bg-green-500 hover:bg-green-600 text-white p-6 rounded-lg shadow transition">
            <div class="flex items-center gap-4">
                <div class="text-3xl">🎓</div>
                <div>
                    <h3 class="font-bold text-lg">Kelola Alumni</h3>
                    <p class="text-sm text-green-100">Lihat & edit data alumni</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                + Tambah User
            </a>
            <a href="{{ route('alumni.s1.pgmi.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                + Tambah Alumni
            </a>
            <a href="{{ route('admin.alumni.template') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                📥 Download Template Excel
            </a>
        </div>
    </div>
</div>
@endsection
