@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative h-[300px] flex items-center justify-center text-center text-white bg-cover bg-center"
    style="background-image: url('{{ asset('images/Branda.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center text-white">
        <h1 class="text-4xl font-bold">Pendidikan Guru Madrasah Ibtidaiyah (PGMI)</h1>
        <p class="mt-2 text-sm">
            <a href="{{ route('dashboard') }}" class="hover:underline">Beranda</a> >
            <a href="{{ route('alumni.data') }}" class="hover:underline">Data Alumni</a> >
            <span>PGMI</span>
        </p>
    </div>
</section>

<!-- Konten Utama -->
<section class="max-w-6xl mx-auto px-6 py-12">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Data Alumni Prodi PGMI</h2>

        <!-- Tombol Tambah Alumni -->
        <a href="{{ route('alumni.s1.pgmi.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-full shadow transition">
           + Tambah Alumni
        </a>
    </div>

    <!-- Filter -->
    <form method="GET" action="{{ route('alumni.s1.pgmi') }}" class="flex flex-wrap justify-center gap-3 mb-10">
        <select name="angkatan" onchange="this.form.submit()"
            class="border border-gray-300 rounded-full px-5 py-2 text-gray-700 focus:ring-green-500 focus:border-green-500 shadow-sm">
            <option value="">-- Angkatan --</option>
            <option value="all" {{ ($angkatan ?? '') === 'all' ? 'selected' : '' }}>Semua</option>
            @foreach($angkatanList as $a)
                <option value="{{ $a }}" {{ ($angkatan ?? '') == $a ? 'selected' : '' }}>{{ $a }}</option>
            @endforeach
        </select>

        <select name="lulusan" onchange="this.form.submit()"
            class="border border-gray-300 rounded-full px-5 py-2 text-gray-700 focus:ring-green-500 focus:border-green-500 shadow-sm">
            <option value="">-- Lulusan --</option>
            <option value="all" {{ ($lulusan ?? '') === 'all' ? 'selected' : '' }}>Semua</option>
            @foreach($lulusanList as $l)
                <option value="{{ $l }}" {{ ($lulusan ?? '') == $l ? 'selected' : '' }}>{{ $l }}</option>
            @endforeach
        </select>
    </form>

    @if($alumni->isEmpty())
        <p class="text-center text-gray-500 italic">Belum ada data alumni untuk pilihan ini.</p>
    @else
        <!-- Grid Alumni -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach($alumni as $a)
            <a href="{{ route('alumni.s1.pgmi.show', $a->id) }}"
               class="bg-white rounded-2xl shadow hover:shadow-md transition p-4 flex flex-col items-center text-center cursor-pointer">
                <div class="w-28 h-28 mb-3 flex items-center justify-center bg-gray-100 rounded-lg overflow-hidden">
                    <img src="{{ asset($a->foto ?? 'images/default.png') }}" 
                         alt="{{ $a->nama }}" class="w-full h-full object-cover">
                </div>
                <h3 class="font-semibold text-gray-800 text-sm">{{ $a->nama }}</h3>
                <p class="text-xs text-gray-500 mt-1">Angkatan {{ $a->angkatan ?? '-' }}</p>
            </a>
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
