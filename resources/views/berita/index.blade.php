@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative">
        <img src="{{ asset('images/hero-berita.jpg') }}" alt="Hero Berita" class="w-full h-72 object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-white">
            <h1 class="text-4xl font-bold">Berita</h1>
            <p class="mt-2 text-sm">
                <a href="{{ route('welcome') }}" class="hover:underline">Beranda</a> > Berita
            </p>
        </div>
    </section>

    <!-- Berita Terbaru (scroll horizontal) -->
    <section class="max-w-6xl mx-auto px-6 py-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Berita Terbaru</h2>

        <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide snap-x snap-mandatory">
            @foreach ($berita as $item)
                <a href="{{ route('berita.show', $item->id) }}"
                    class="bg-white min-w-[300px] rounded-xl shadow hover:shadow-lg overflow-hidden transition flex-shrink-0">
                    <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <p class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="bi bi-calendar-event me-2 text-green-600"></i>
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                        </p>
                        <h3 class="font-semibold text-lg text-gray-800">{{ $item->judul }}</h3>
                        <p class="text-sm text-gray-600 mt-2">{{ Str::limit($item->isi, 80, '...') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Lowongan Pekerjaan -->
    <section class="max-w-6xl mx-auto px-6 py-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Lowongan Pekerjaan</h2>

        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white shadow rounded-2xl overflow-hidden">
                <img src="{{ asset('images/LK.jpeg') }}" class="w-full object-cover h-96" alt="Lowongan 1">
                <div class="p-4 text-center">
                    <h4 class="font-bold text-lg">Accounting</h4>
                    <p class="text-sm text-gray-500">PERBARINDO Indonesia</p>
                </div>
            </div>
            <div class="bg-white shadow rounded-2xl overflow-hidden">
                <img src="{{ asset('images/LK.jpeg') }}" class="w-full object-cover h-96" alt="Lowongan 2">
                <div class="p-4 text-center">
                    <h4 class="font-bold text-lg">Accounting</h4>
                    <p class="text-sm text-gray-500">PERBARINDO Indonesia</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('lowongan.index') }}"
                class="inline-block bg-yellow-500 text-white px-6 py-3 rounded-full font-semibold hover:bg-yellow-400 transition">
                Selengkapnya...
            </a>
        </div>
    </section>
@endsection
