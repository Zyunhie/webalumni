@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    <div class="flex items-center mb-8">
        <a href="{{ route('admin.berita.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white shadow-2xl rounded-3xl overflow-hidden">
        @if($berita->gambar)
            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-96 object-cover">
        @endif
        
        <div class="p-12">
            <span class="inline-block px-4 py-2 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                {{ \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}
            </span>
            
            <h1 class="text-4xl font-bold text-gray-900 mt-4 mb-6 leading-tight">{{ $berita->judul }}</h1>
            
            <div class="prose prose-lg max-w-none">
                {!! $berita->isi !!}
            </div>
        </div>
    </div>
</div>
@endsection
