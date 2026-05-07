@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative h-[400px] bg-cover bg-center overflow-hidden"
    style="background-image: url('{{ isset($heroBerita) && $heroBerita ? Storage::url($heroBerita->gambar) : asset('images/Branda.jpg') }}');">

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