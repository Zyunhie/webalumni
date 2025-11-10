@extends('layouts.app')

@section('content')
<div class="bg-gray-100 py-10">
    <div class="max-w-4xl mx-auto px-6">
        <!-- Card Putih -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Judul -->
            <div class="p-8 text-center border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $berita->judul }}</h1>
                <p class="text-sm text-gray-500 flex justify-center items-center gap-2">
                    <i class="bi bi-calendar-event text-green-600"></i>
                    {{ \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}
                </p>
            </div>

            <!-- Gambar -->
            @if($berita->gambar)
                <img src="{{ asset($berita->gambar) }}" 
     alt="{{ $berita->judul }}" 
     class="w-full h-96 object-cover rounded-xl shadow-md mx-auto">
            @endif

            <!-- Isi Berita -->
            <div class="p-8 text-gray-700 leading-relaxed">
                {!! nl2br(e($berita->isi)) !!}
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="text-center mt-8">
            <a href="{{ route('berita') }}" 
               class="inline-block bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 transition">
               ← Kembali ke Berita
            </a>
        </div>
    </div>
</div>
@endsection
