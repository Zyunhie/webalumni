@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <section class="relative h-[400px] flex items-center justify-center text-center text-white bg-cover bg-center"
        style="background-image: url('{{ asset('images/Branda.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 max-w-4xl mx-auto">
            <h1 class="text-3xl md:text-5xl font-bold mb-4">SELAMAT DATANG DI WEBSITE ALUMNI </h1>
            <h2 class="relative z-10 mx-w-4xl mx-auto">INSTITUT AGAMA ISLAM TASIKMALAYA</h2>
            <p class="mb-6">Temukan Teman Satu Angkatan, ikuti event serta bangun koneksi bersama Alumni!</p>
            <div class="flex justify-center gap-4">
                <a href="/" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg shadow">Gabung Alumni</a>
                <a href="{{ route('alumni.data') }}" class="bg-white hover:bg-gray-200 text-gray-800 px-6 py-2 rounded-lg shadow">Lihat Data Alumni</a>
            </div>
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
            <a href="{{ route('tentang') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow">
                Selengkapnya...
            </a>
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
                @for ($i = 0; $i < 3; $i++)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <img src="{{ asset('images/L.jpeg') }}" alt="Agenda" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2">Seminar Event</h3>
                            <p class="text-sm text-gray-600">Nov 27, 2025 - 09:00 AM</p>
                            <p class="mt-2 text-gray-600">Kegiatan seminar untuk alumni dalam rangka silaturahmi...</p>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    {{-- Berita Terbaru --}}
    <section class="py-12 bg-gray-100">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6">Informasi Dan Berita Terbaru</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @for ($i = 0; $i < 2; $i++)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <img src="{{ asset('images/L.jpeg') }}" alt="Berita" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <p class="text-sm text-green-600 font-semibold mb-2">14 SEP 2025</p>
                            <h3 class="font-bold text-lg mb-2">Pengambilan Foto Alumni Peserta Wisuda 2024 - 2025</h3>
                            <p class="text-gray-600 text-sm">
                                Pengambilan foto alumni peserta wisuda tahun akademik 2024–2025 telah dilaksanakan...
                            </p>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="text-center mt-6">
                <a href="{{ route('berita.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow">
                    Baca Berita Lainnya
                </a>
            </div>
        </div>
    </section>
@endsection
