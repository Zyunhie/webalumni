@extends('layouts.app')

@section('content')
<!-- Hero Section -->
@php
    // Mapping kode prodi ke nama lengkap
    $prodiNames = [
        'PGMI' => 'Pendidikan Guru Madrasah Ibtidaiyah (PGMI)',
        'PAI' => 'Pendidikan Agama Islam (PAI)',
        'PIAUD' => 'Pendidikan Islam Anak Usia Dini (PIAUD)',
        'MPI' => 'Manajemen Pendidikan Islam (MPI)',
        'BKPI' => 'Bimbingan dan Konseling Pendidikan Islam (BKPI)',
        'EKSYAR' => 'Ekonomi Syari\'ah (EKSYAR)',
        'AS' => 'Hukum Keluarga Islam (AS)',
        'HTN' => 'Hukum Tata Negara (HTN)',
        'PAI (S2)' => 'Pendidikan Agama Islam (PAI) S2',
    ];
    $pageTitle = $prodiNames[$prodi] ?? 'Data Alumni';
@endphp

<section class="relative h-[300px] flex items-center justify-center text-center text-white bg-cover bg-center"
    style="background-image: url('{{ asset('images/Branda.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center text-white">
        <h1 class="text-4xl font-bold">{{ $pageTitle }}</h1>
        <p class="mt-2 text-sm">
            <a href="{{ route('dashboard') }}" class="hover:underline">Beranda</a> >
            <a href="{{ route('alumni.data') }}" class="hover:underline">Data Alumni</a> >
            <span>{{ $prodi ?? 'Semua' }}</span>
        </p>
    </div>
</section>

<!-- Konten Utama -->
@php
    // Mapping kode prodi ke route name
    $prodiRoutes = [
        'PGMI' => 'alumni.s1.pgmi.',
        'PAI' => 'alumni.s1.pai.',
        'PIAUD' => 'alumni.s1.piaud.',
        'MPI' => 'alumni.s1.mpi.',
        'BKPI' => 'alumni.s1.bkpi.',
        'EKSYAR' => 'alumni.s1.eksyar.',
        'AS' => 'alumni.s1.as.',
        'HTN' => 'alumni.s1.htn.',
        'PAI (S2)' => 'alumni.s2.pai.',
    ];
    $routePrefix = $prodiRoutes[$prodi] ?? 'alumni.s1.pgmi.';
    $pageTitleProdi = $prodiNames[$prodi] ?? 'Data Alumni';
@endphp

<section class="max-w-6xl mx-auto px-6 py-12">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Data Alumni Prodi {{ $prodi ?? '' }}</h2>

        <!-- Tombol Tambah Alumni & Import Excel (HANYA ADMIN) -->
        @auth
        @if(auth()->user()->role === 'admin')
        <div class="flex gap-2">
            <!-- Import Excel Button -->
            <button type="button" onclick="document.getElementById('importModal').showModal()"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-full shadow transition">
                📥 Import Excel
            </button>
            
            <a href="{{ route('alumni.data') }}"
               class="bg-gray-500 hover:bg-gray-400 text-white font-semibold px-5 py-2 rounded-full shadow transition">
               ← Kembali
            </a>
        </div>
        @endif
        @endauth
    </div>

    <!-- Modal Import Excel -->
    <dialog id="importModal" class="modal p-6 bg-white rounded-lg shadow-xl">
        <div class="w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Import Data Alumni</h3>
                <button type="button" onclick="document.getElementById('importModal').close()" 
                    class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            
            <p class="text-sm text-gray-600 mb-4">
                Upload file CSV (.csv) untuk mengimport data alumni secara massal.
            </p>

            <!-- Link Download Template -->
            <div class="mb-4">
                <a href="{{ route('admin.alumni.template') }}" 
                   class="text-blue-600 hover:underline text-sm">
                    📄 Download Template CSV
                </a>
            </div>

            <!-- Form Import -->
            <form action="{{ route('admin.alumni.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".xlsx,.xls,.csv" 
                    class="w-full border border-gray-300 rounded p-2 mb-4" required>
                
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('importModal').close()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Import</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Filter -->
    <form method="GET" action="{{ route($routePrefix . 'index') }}" class="flex flex-wrap justify-center gap-3 mb-10">
        <select name="angkatan" onchange="this.form.submit()"
            class="border border-gray-300 rounded-full px-5 py-2 text-gray-700 focus:ring-green-500 focus:border-green-500 shadow-sm">
            <option value="">-- Angkatan --</option>
            <option value="all">Semua</option>
            @foreach($angkatanList as $a)
                <option value="{{ $a }}" {{ request('angkatan') == $a ? 'selected' : '' }}>{{ $a }}</option>
            @endforeach
        </select>

        <select name="lulusan" onchange="this.form.submit()"
            class="border border-gray-300 rounded-full px-5 py-2 text-gray-700 focus:ring-green-500 focus:border-green-500 shadow-sm">
            <option value="">-- Lulusan --</option>
            <option value="all">Semua</option>
            @foreach($lulusanList as $l)
                <option value="{{ $l }}" {{ request('lulusan') == $l ? 'selected' : '' }}>{{ $l }}</option>
            @endforeach
        </select>
    </form>

    @if($alumni->isEmpty())
        <p class="text-center text-gray-500 italic">Belum ada data alumni untuk pilihan ini.</p>
    @else
        <!-- Grid Alumni -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach($alumni as $a)
            <div class="relative">

                {{-- STATUS BADGE (USER & ADMIN BISA LIHAT) --}}
                @auth
                <span class="absolute top-2 right-2 text-xs px-2 py-1 rounded
                    @if($a->status === 'approved') bg-green-100 text-green-700
                    @elseif($a->status === 'pending') bg-yellow-100 text-yellow-700
                    @else bg-red-100 text-red-700
                    @endif">
                    {{ ucfirst($a->status) }}
                </span>
                @endauth

                <a href="{{ route($routePrefix . 'show', $a->id) }}"
                   class="bg-white rounded-2xl shadow hover:shadow-md transition p-4 flex flex-col items-center text-center cursor-pointer">
                    <div class="w-28 h-28 mb-3 flex items-center justify-center bg-gray-100 rounded-lg overflow-hidden">
                        <img src="{{ $a->foto_url }}" 
                             alt="{{ $a->nama }}" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-gray-800 text-sm">{{ $a->nama }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Angkatan {{ $a->angkatan ?? '-' }}</p>
                </a>

                {{-- AKSI EDIT & HAPUS (UNTUK ADMIN ATAU PEMILIK) --}}
                @auth
                    {{-- Admin bisa edit/hapus semua data, user biasa hanya bisa edit datanya sendiri --}}
                    @if(auth()->user()->role === 'admin' || auth()->id() === $a->user_id)
                    <div class="flex justify-center gap-2 mt-2">
                        {{-- Tombol Edit --}}
                        <a href="{{ route($routePrefix . 'edit', $a->id) }}"
                           class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                            Edit
                        </a>

                        {{-- Tombol Hapus (hanya untuk admin) --}}
                        @if(auth()->user()->role == 'admin')
                        <form action="{{ route($routePrefix . 'destroy', $a->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                    @endif
                @endauth

                {{-- ADMIN FEATURE: APPROVE/REJECT (hanya untuk pending) --}}
                @auth
                @if(auth()->user()->role == 'admin' && $a->status === 'pending')
                <div class="flex justify-center gap-2 mt-2">
                    <form action="{{ route('admin.alumni.approve', $a->id) }}" method="POST">
                        @csrf
                        <button class="text-xs bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                            Approve
                        </button>
                    </form>

                    <form action="{{ route('admin.alumni.reject', $a->id) }}" method="POST">
                        @csrf
                        <button class="text-xs bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                            Reject
                        </button>
                    </form>
                </div>
                @endif
                @endauth

            </div>
            @endforeach
        </div>
    @endif

    <div class="text-center mt-10">
        <a href="{{ route('alumni.data') }}" 
           class="inline-block bg-gray-500 hover:bg-gray-400 text-white px-6 py-2 rounded-full font-semibold transition">
           ← Kembali ke Data Alumni
        </a>
    </div>
</section>
@endsection
