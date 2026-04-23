@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative h-[400px] flex items-center justify-center text-center text-white bg-cover bg-center"
        style="background-image: url('{{ asset('images/Branda.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-white">
            <h1 class="text-4xl font-bold">Berita</h1>
            <p class="mt-2 text-sm">
                <a href="{{ route('dashboard') }}" class="hover:underline">Beranda</a> > Berita
            </p>
        </div>
    </section>

    <!-- Berita Terbaru -->
    <section class="max-w-6xl mx-auto px-6 py-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Berita Terbaru</h2>

        <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide snap-x snap-mandatory">
            @foreach ($berita as $item)
                <a href="{{ route('berita.show', $item->id) }}"
                    class="bg-white min-w-[300px] rounded-xl shadow hover:shadow-lg overflow-hidden transition flex-shrink-0">
                    <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('images/placeholder.jpg') }}"
                         alt="{{ $item->judul }}"
                         class="w-full h-48 object-cover"
                         onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}'">
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
@endsection