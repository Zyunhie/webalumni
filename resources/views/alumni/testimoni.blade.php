@extends('layouts.app')

@section('content')
<!-- Hero Section -->
 <section class="relative h-[400px] flex items-center justify-center text-center text-white bg-cover bg-center"
        style="background-image: url('{{ asset('images/Branda.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-white">
        <h1 class="text-4xl font-bold">Alumni</h1>
        <p class="mt-2 text-sm">
            <a href="{{ route('dashboard') }}" class="hover:underline">Beranda</a> >
            Testimoni Alumni
        </p>
    </div>
</section>

<!-- Testimoni Alumni -->
<section class="max-w-6xl mx-auto px-6 py-12">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Testimoni Alumni</h2>
    <p class="text-gray-600 mb-6">Cerita dan Pengalaman Alumni Setelah Lulus</p>

    <div class="flex space-x-6 overflow-x-auto pb-6 scrollbar-hide">
        @for($i = 0; $i < 3; $i++)
            <div class="bg-[#D5F9FC] min-w-[280px] rounded-xl shadow-md p-6 flex flex-col items-center text-center">
                <img src="{{ asset('images/K.jpeg') }}" class="w-24 h-24 rounded-full object-cover mb-4" alt="Alumni">
                <h3 class="font-bold text-lg text-gray-800">Andika Perkasa</h3>
                <p class="text-gray-600">Manajemen Informatika</p>
            </div>
        @endfor
    </div>

    <div class="flex justify-center mt-6 space-x-2">
        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
        <span class="w-2 h-2 bg-green-600 rounded-full"></span>
    </div>
</section>
@endsection
