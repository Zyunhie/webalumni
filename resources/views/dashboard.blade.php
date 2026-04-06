@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <section class="relative h-[400px] flex items-center justify-center text-center text-white bg-cover bg-center"
        style="background-image: url('{{ asset('images/Branda.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 max-w-4xl mx-auto">
            <h1 class="text-3xl md:text-5xl font-bold mb-4">SELAMAT DATANG DI WEBSITE ALUMNI</h1>
            <h2 class="relative z-10 max-w-4xl mx-auto">INSTITUT AGAMA ISLAM TASIKMALAYA</h2>
            <p class="mb-6">Temukan teman satu angkatan, ikuti event serta bangun koneksi bersama Alumni!</p>
        </div>
    </section>

    {{-- Tentang Kami --}}
    <section class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold mb-4">Tentang Kami</h2>
            <p class="text-gray-600 mb-6">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore
                et dolore magna aliqua.
            </p>
            @guest
                <a href="{{ route('login') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow">
                    Selengkapnya...
                </a>
            @else
                <a href="{{ route('tentang') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow">
                    Selengkapnya...
                </a>
            @endguest
        </div>
    </section>

    {{-- Statistik Alumni --}}
    <section class="py-12 bg-gray-100">
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-6 text-center px-4">
            <div class="bg-white p-6 shadow rounded-lg">
                <p class="text-3xl font-bold text-green-600">8,347+</p>
                <p class="text-gray-600">Alumni</p>
            </div>
            <div class="bg-white p-6 shadow rounded-lg">
                <p class="text-3xl font-bold text-green-600">8,441+</p>
                <p class="text-gray-600">Bekerja</p>
            </div>
            <div class="bg-white p-6 shadow rounded-lg">
                <p class="text-3xl font-bold text-green-600">10%</p>
                <p class="text-gray-600">Success Rate</p>
            </div>
        </div>
    </section>

    {{-- Agenda --}}
    <section class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6">Agenda</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach(App\Models\Agenda::latest()->take(3)->get() as $agenda)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <img src="{{ $agenda->gambar ? asset('storage/' . $agenda->gambar) : asset('images/L.jpeg') }}" 
                             alt="Agenda" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2">{{ $agenda->judul }}</h3>
                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($agenda->tanggal_mulai)->format('d M Y') }} 
                                @if($agenda->tanggal_selesai) - {{ \Carbon\Carbon::parse($agenda->tanggal_selesai)->format('d M Y') }} @endif
                            </p>
                            <p class="mt-2 text-gray-600 text-sm">{{ Str::limit($agenda->deskripsi, 60) }}</p>
                            @guest
                                <a href="{{ route('login') }}"
                                   class="text-orange-500 hover:underline text-sm mt-2 inline-block">Selengkapnya...</a>
                            @else
                                <a href="{{ route('agenda.index') }}"
                                   class="text-orange-500 hover:underline text-sm mt-2 inline-block">Selengkapnya...</a>
                            @endguest
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Berita Terbaru --}}
    <section class="py-12 bg-gray-100">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6">Informasi dan Berita Terbaru</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach(App\Models\Berita::latest()->take(2)->get() as $berita)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <img src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : asset('images/L.jpeg') }}" 
                             alt="Berita" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <p class="text-sm text-green-600 font-semibold mb-2">{{ \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}</p>
                            <h3 class="font-bold text-lg mb-2">{{ $berita->judul }}</h3>
                            <p class="text-gray-600 text-sm">{{ Str::limit($berita->isi, 60) }}</p>
                            @guest
                                <a href="{{ route('login') }}"
                                   class="text-orange-500 hover:underline text-sm mt-2 inline-block">Baca Selengkapnya...</a>
                            @else
                                <a href="{{ route('berita.show', $berita->id) }}"
                                   class="text-orange-500 hover:underline text-sm mt-2 inline-block">Baca Selengkapnya...</a>
                            @endguest
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-6">
                @guest
                    <a href="{{ route('login') }}"
                       class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow">
                       Baca Berita Lainnya
                    </a>
                @else
                    <a href="{{ route('berita.index') }}"
                       class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow">
                       Baca Berita Lainnya
                    </a>
                @endguest
            </div>
        </div>
    </section>
@endsection
