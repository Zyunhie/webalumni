@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative h-[400px] flex items-center justify-center text-center text-white bg-cover bg-center"
        style="background-image: url('{{ asset('images/Branda.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-white">
        <h1 class="text-4xl font-bold">Lowongan Pekerjaan</h1>
        <p class="mt-2 text-sm">
            <a href="{{ route('dashboard') }}" class="hover:underline">Beranda</a> > Lowongan Pekerjaan
        </p>
    </div>
</section>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Judul -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-green-700">Daftar lowongan terbaru untuk alumni IAIT</h1>
        </div>

        @php
            $showAll = request()->query('all') == 1;
            $items = $lowongan ?? collect();
        @endphp

        <!-- Grid lowongan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @if($items->isEmpty())
                <p class="text-center col-span-3 text-gray-500">Belum ada lowongan saat ini. Pantau terus halaman ini.</p>
            @else
                @foreach($items as $index => $item)
                    @if(!$showAll && $index >= 9)
                        @break
                    @endif
                    <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col">
                        <div class="h-40 w-full overflow-hidden">
                            @if($item->gambar)
                                <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('images/LK.jpeg') }}" alt="placeholder" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $item->judul }}</h3>
                            <p class="text-sm text-gray-500 mb-4">{{ $item->perusahaan ?? 'Perusahaan tidak disebutkan' }}</p>
                            <div class="mt-auto flex items-center justify-between">
                                <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($item->tanggal ?? now())->format('d M Y') }}</p>
                                <a href="{{ route('lowongan.show', $item->id) }}" class="text-sm bg-green-600 text-white px-3 py-1 rounded-full hover:bg-green-700 transition">Lihat</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Tombol lihat semua / kembali -->
        <div class="mt-10 text-center">
            @if(!$showAll && $items->count() > 9)
                <a href="{{ route('lowongan.index', ['all' => 1]) }}" class="inline-block bg-yellow-500 text-white px-6 py-2 rounded-full hover:bg-yellow-400 transition">
                    Lihat Semua Lowongan
                </a>
            @elseif($showAll)
                <a href="{{ route('lowongan.index') }}" class="inline-block bg-gray-500 text-white px-6 py-2 rounded-full hover:bg-gray-400 transition">
                    Kembali
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
