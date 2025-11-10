@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative">
    <img src="{{ asset('images/hero-tentang.jpg') }}" alt="Tentang Kami" class="w-full h-72 object-cover">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-white">
        <h1 class="text-4xl font-bold">Tentang Kami</h1>
        <p class="mt-2 text-sm">
            <a href="{{ route('welcome') }}" class="hover:underline">Beranda</a> > Tentang
        </p>
    </div>
</section>

<!-- Deskripsi -->
<section class="max-w-5xl mx-auto px-6 py-12 text-center">
    <h2 class="text-2xl font-bold text-green-700 mb-4">Website Alumni Institut Agama Islam Tasikmalaya</h2>
    <p class="text-gray-700 leading-relaxed">
        Website ini dibuat sebagai wadah komunikasi dan informasi antara para alumni Institut Agama Islam Tasikmalaya.
        Melalui platform ini, alumni dapat berbagi pengalaman, mengikuti agenda kampus, serta membuka peluang kerja sama.
        Kami berharap website ini menjadi penghubung yang mempererat tali silaturahmi antar alumni IAIT.
    </p>
</section>

<!-- Visi dan Misi -->
<section class="bg-gray-100 py-12">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl shadow p-8">
            <h3 class="text-xl font-bold text-green-700 mb-4">Visi</h3>
            <p class="text-gray-700">
                Menjadi wadah yang aktif, inspiratif, dan bermanfaat bagi seluruh alumni Institut Agama Islam Tasikmalaya
                dalam membangun jaringan profesional dan sosial yang berkelanjutan.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow p-8">
            <h3 class="text-xl font-bold text-green-700 mb-4">Misi</h3>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Membangun jaringan antar alumni lintas angkatan dan jurusan.</li>
                <li>Menyediakan informasi tentang kegiatan dan peluang kerja bagi alumni.</li>
                <li>Mendorong kontribusi alumni dalam pengembangan kampus IAIT.</li>
                <li>Meningkatkan solidaritas dan kebersamaan antar alumni.</li>
            </ul>
        </div>
    </div>
</section>

<!-- Struktur Kampus -->
<section class="py-16 bg-white pb-12">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-2xl font-bold text-green-700 mb-8 pt-8">Struktur Kampus IAIT</h2>

        <div class="bg-gray-50 p-6 rounded-xl shadow">
            <img src="{{ asset('images/S.png') }}" 
                 alt="Struktur Kampus IAIT" 
                 class="w-full rounded-lg object-contain mx-auto">
        </div>
    </div>
</section>
@endsection
