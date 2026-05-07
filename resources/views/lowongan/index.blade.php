@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative h-[400px] flex items-center justify-center text-center text-white bg-cover bg-center"
    style="background-image: url('{{ isset($heroLowongan) && $heroLowongan ? Storage::url($heroLowongan->gambar) : asset('images/Branda.jpg') }}');">
    
    @if(auth()->check() && auth()->user()->role === 'admin')
        <a href="{{ route('admin.hero.index') }}"
            class="absolute bottom-4 right-4 z-10 bg-white bg-opacity-90 hover:bg-opacity-100 text-green-700 font-semibold text-xs px-4 py-2 rounded-full shadow-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Kelola Slider
        </a>
    @endif
</section>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Judul + Tombol Ajukan (untuk alumni) -->
        <div class="mb-8 flex items-center justify-between">
            <div class="text-center flex-1">
                <h1 class="text-3xl font-bold text-green-700">Daftar lowongan terbaru untuk alumni IAIT</h1>
            </div>
            @auth
                @if(auth()->user()->role === 'alumni')
                    <a href="{{ route('alumni.lowongan.create') }}"
                       class="ml-4 inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-full hover:bg-green-700 transition whitespace-nowrap">
                        + Ajukan Lowongan
                    </a>
                @endif
            @endauth
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-md bg-green-50 p-4 text-sm text-green-800 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        @php
            $showAll = request()->query('all') == 1;
            $items   = $lowongans ?? collect();
        @endphp

        <!-- Grid lowongan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($items as $index => $item)
                @if(!$showAll && $index >= 9)
                    @break
                @endif
                <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col">
                    <div class="h-40 w-full overflow-hidden">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/LK.jpeg') }}" alt="placeholder" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $item->judul }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ $item->perusahaan ?? 'Perusahaan tidak disebutkan' }}</p>
                        <div class="mt-auto flex items-center justify-between">
                            <p class="text-xs text-gray-400">{{ $item->created_at->format('d M Y') }}</p>
                            <a href="{{ route('lowongan.show', $item->id) }}"
                               class="text-sm bg-green-600 text-white px-3 py-1 rounded-full hover:bg-green-700 transition">Lihat</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center col-span-3 text-gray-500">Belum ada lowongan saat ini. Pantau terus halaman ini.</p>
            @endforelse
        </div>

        <!-- Tombol lihat semua / kembali -->
        <div class="mt-10 text-center">
            @if(!$showAll && $items->count() > 9)
                <a href="{{ route('lowongan.index', ['all' => 1]) }}"
                   class="inline-block bg-yellow-500 text-white px-6 py-2 rounded-full hover:bg-yellow-400 transition">
                    Lihat Semua Lowongan
                </a>
            @elseif($showAll)
                <a href="{{ route('lowongan.index') }}"
                   class="inline-block bg-gray-500 text-white px-6 py-2 rounded-full hover:bg-gray-400 transition">
                    Kembali
                </a>
            @endif
        </div>

        <!-- Link ke lowongan saya (untuk alumni) -->
        @auth
            @if(auth()->user()->role === 'alumni')
                <div class="mt-6 text-center">
                    <a href="{{ route('alumni.lowongan.my') }}" class="text-sm text-green-600 hover:underline">
                        Lihat lowongan yang saya ajukan →
                    </a>
                </div>
            @endif
        @endauth

    </div>
</div>
@endsection