@extends('layouts.app')

@section('content')
<!-- Hero Section -->
 <section class="relative h-[400px] flex items-center justify-center text-center text-white bg-cover bg-center"
        style="background-image: url('{{ asset('images/Branda.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-white">
        <h1 class="text-4xl font-bold">Agenda</h1>
        <p class="mt-2 text-sm">
            <a href="{{ route('dashboard') }}" class="hover:underline">Beranda</a> > Agenda
        </p>
    </div>
</section>

<!-- Detail Agenda -->
<section class="max-w-5xl mx-auto px-6 py-12">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">
        Membangun Karakter, Menguatkan Karir, dan Menyiapkan Generasi Alumni Unggul untuk Masa Depan
    </h2>
    <p class="text-green-700 font-medium mb-6 flex items-center gap-2">
        <i class="bi bi-person-fill"></i> Oleh: Kantor Alumni
    </p>

    <div class="bg-gray-100 p-6 rounded-lg mb-8 text-sm text-gray-700">
        <p><strong>Penyelenggara:</strong> Institut Agama Islam Tasikmalaya bekerjasama dengan PT United Family Food</p>
        <p><strong>Lokasi:</strong> Aula Gedung Rektorat</p>
        <p><strong>Waktu:</strong> Kamis, 11 September 2025</p>
    </div>

    <img src="{{ asset('images/LK.jpeg') }}" alt="Seminar" class="rounded-lg shadow-md mb-8 w-full max-w-3xl mx-auto">

    <div class="prose text-gray-700 leading-relaxed">
        <p>✨ <strong>Hello, Institut Agama Islam Tasikmalaya!</strong></p>
        <p>🎓 Membangun Karakter, Menguatkan Karir, dan Menyiapkan Generasi Alumni Unggul untuk Masa Depan ✨</p>
        <p>
            Get ready for an inspiring alumni session with GENIAIT (Generasi Alumni IAIT) dan dapatkan wawasan berharga 
            untuk menapaki perjalanan karir sekaligus memperkuat kontribusi sebagai alumni!
        </p>
        <ul class="list-disc pl-6">
            <li>📅 Date: Thursday, September 11, 2025</li>
            <li>⏰ Time: 08:00 AM</li>
            <li>📍 Location: Aula Utama Institut Agama Islam Tasikmalaya</li>
            <li>🎤 Speakers:
                <ul class="pl-6 list-disc">
                    <li>Dr. H. Cecep, M.Ag – Rektor IAIT</li>
                    <li>Puji Haryadi – Praktisi & Inspirator Alumni IAIT</li>
                </ul>
            </li>
            <li>✅ Motivasi & inspirasi dari alumni sukses</li>
            <li>✅ Networking antar mahasiswa dan alumni</li>
            <li>✅ Penguatan peran alumni untuk umat & bangsa</li>
        </ul>
    </div>

    <div class="flex justify-center space-x-4 mt-10 text-2xl text-green-700">
        <i class="bi bi-facebook hover:text-green-500 cursor-pointer"></i>
        <i class="bi bi-instagram hover:text-green-500 cursor-pointer"></i>
        <i class="bi bi-whatsapp hover:text-green-500 cursor-pointer"></i>
    </div>
</section>
@endsection
