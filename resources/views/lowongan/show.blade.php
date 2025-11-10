@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative">
    <img src="{{ asset('images/hero-berita.jpg') }}" alt="Hero Lowongan" class="w-full h-72 object-cover">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-white">
        <h1 class="text-4xl font-bold">{{ $lowongan->judul }}</h1>
        <p class="mt-2 text-sm">
            <a href="{{ route('welcome') }}" class="hover:underline">Beranda</a> > 
            <a href="{{ route('lowongan.index') }}" class="hover:underline">Lowongan Pekerjaan</a> > 
            Detail
        </p>
    </div>
</section>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Tombol Kirim CV di pojok kanan atas -->
        <div class="flex justify-end mb-6">
            <a href="#" class="inline-block bg-yellow-500 hover:bg-yellow-400 text-white font-bold py-2 px-6 rounded-lg transition">
                Kirim CV Mu Sekarang
            </a>
        </div>

        <!-- Konten Utama (2 Kolom) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Kolom Kiri: Gambar Lowongan -->
            <div class="lg:col-span-1">
                @if($lowongan->gambar)
                    <img src="{{ asset($lowongan->gambar) }}" alt="{{ $lowongan->judul }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                        No Image Available
                    </div>
                @endif
            </div>

            <!-- Kolom Kanan: Info Lowongan + Profile Perusahaan -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Judul Posisi -->
                <h1 class="text-3xl font-extrabold text-green-700">{{ $lowongan->judul }}</h1>

                <!-- Detail Lowongan -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4 text-green-700">Detail Lowongan</h2>
                    <div class="space-y-2 text-gray-700">
                        <p><strong>Lokasi:</strong> {{ $lowongan->lokasi ?? 'Indonesia' }}</p>
                        <p><strong>Tanggal Posting:</strong> {{ \Carbon\Carbon::parse($lowongan->tanggal_post)->format('d-m-Y') }}</p>
                        <p><strong>Alamat:</strong> {{ $lowongan->alamat ?? 'Komp. Patra II No. 46, JL. Jend. Ahmad Yani - Bypass Cempaka Putih, Jakarta Pusat' }}</p>
                        <p><strong>Batas Lamaran:</strong> {{ $lowongan->batas_lamaran ? \Carbon\Carbon::parse($lowongan->batas_lamaran)->format('d-m-Y') : '-' }}</p>
                    </div>
                </div>

                <!-- Profile Perusahaan -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4 text-green-700">Profile Perusahaan</h2>
                    <h3 class="text-2xl font-bold mb-3">{{ $lowongan->perusahaan ?? 'Keuangan' }}</h3>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $lowongan->profile_perusahaan ?? 'Perbarindo adalah organisasi yang menaungi BPR dan BPRS di Indonesia sejak 1995, berfokus pada penguatan daya saing, profesionalisme, serta sinergi untuk mendukung regulasi dan inovasi industri perbankan rakyat.' }}
                    </p>
                </div>

                <!-- Deskripsi Pekerjaan -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4 text-green-700">Deskripsi Pekerjaan</h2>
                    <div class="text-gray-700 leading-relaxed">
                        {!! nl2br(e($lowongan->deskripsi)) !!}
                    </div>
                </div>

                <!-- Tombol Kembali -->
                <div class="mt-6">
                    <a href="{{ route('lowongan.index') }}" class="inline-block bg-gray-500 text-white px-6 py-2 rounded-full hover:bg-gray-400 transition">
                        Kembali ke Lowongan
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection