@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative h-[400px] flex items-center justify-center text-center text-white bg-cover bg-center"
        style="background-image: url('{{ asset('images/Branda.jpg') }}');">
</section>

<section class="max-w-6xl mx-auto px-6 py-12">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Galeri Testimoni Alumni</h2>
        <p class="text-xl text-gray-600 mb-8">Lihat testimoni terbaru dari alumni kami yang sudah disetujui</p>
        @auth
        <div class="space-x-4">
            <a href="{{ route('testimoni.create') }}" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold shadow-lg">
                Tambah Testimoni Saya
            </a>
            @if(auth()->user()->role == 'admin')
            <a href="{{ route('admin.testimoni.pending') }}" class="inline-flex items-center bg-yellow-600 hover:bg-yellow-700 text-white px-8 py-3 rounded-lg font-semibold shadow-lg">
                Kelola Testimoni
            </a>
            @endif
        </div>
        @endauth
    </div>

    @include('testimoni.index')
</section>
@endsection
