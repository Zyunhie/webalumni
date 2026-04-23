@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative h-[400px] flex items-center justify-center text-center text-white bg-cover bg-center"
    style="background-image: url('{{ asset('images/Branda.jpg') }}');">
</section>

<!-- Kontak Form dan Info -->
<section class="max-w-6xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-2 gap-10">
    <!-- Form -->
    <div class="bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Kirim Pesan</h2>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('kontak.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500">
                @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="pesan" class="block text-sm font-semibold text-gray-700">Pesan</label>
                <textarea id="pesan" name="pesan" rows="5" required
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500">{{ old('pesan') }}</textarea>
                @error('pesan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                Kirim Pesan
            </button>
        </form>
    </div>

    <!-- Info Kampus -->
    <div class="bg-gray-50 shadow-lg rounded-2xl p-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Informasi Kampus</h2>
        <p class="text-gray-700 mb-2">
            <i class="bi bi-geo-alt-fill text-green-600 mr-2"></i>
            Jl. RE Martadinata No.273, Cipedes, Kota Tasikmalaya
        </p>
        <p class="text-gray-700 mb-2">
            <i class="bi bi-telephone-fill text-green-600 mr-2"></i>
            (0265) 123456
        </p>
        <p class="text-gray-700 mb-2">
            <i class="bi bi-envelope-fill text-green-600 mr-2"></i>
            info@iaitasikmalaya.ac.id
        </p>
        <p class="text-gray-700 mb-6">
            <i class="bi bi-clock-fill text-green-600 mr-2"></i>
            Senin - Jumat, 08.00 - 16.00 WIB
        </p>

        <h3 class="text-lg font-semibold mb-2 text-gray-800">Lokasi Kami</h3>
        <div class="rounded-xl overflow-hidden shadow">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.770618431749!2d108.20177527487822!3d-7.813584177212663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6591d9ff7eafdd%3A0x6e46301b729f02c!2sInstitut%20Agama%20Islam%20Tasikmalaya!5e0!3m2!1sid!2sid!4v1701234567890!5m2!1sid!2sid" 
                width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
        </div>
    </div>
</section>

<div class="mb-12"></div>
@endsection