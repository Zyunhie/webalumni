@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative h-[400px] flex items-center justify-center text-center text-white bg-cover bg-center"
    style="background-image: url('{{ asset('images/Branda.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-white">
        <h1 class="text-4xl font-bold">Data Alumni</h1>
        <p class="mt-2 text-sm">
            <a href="{{ route('dashboard') }}" class="hover:underline">Beranda</a> > Data Alumni
        </p>
    </div>
</section>

<!-- Konten -->
<section class="max-w-6xl mx-auto px-6 py-12 space-y-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Pilih Jenjang Pendidikan</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-center">
        
        <!-- ==================== S1 ==================== -->
        <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-lg transition">
            <h3 class="text-2xl font-bold text-green-700 mb-4">S1</h3>
            <button onclick="toggleMenu('fakultasS1')" 
                class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold px-6 py-2 rounded-full transition">
                Lihat Fakultas
            </button>

            <!-- Daftar Fakultas S1 -->
            <div id="fakultasS1" class="hidden space-y-4 mt-6 text-left">

                <!-- Fakultas Tarbiyah -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <h4 class="font-bold text-green-700">Fakultas Tarbiyah</h4>
                    <ul class="ml-5 mt-2 list-disc text-gray-700 space-y-1">
                        <li><a href="{{ route('alumni.s1.pai.index') }}" class="hover:underline">Pendidikan Agama Islam (PAI)</a></li>
                        <li><a href="{{ route('alumni.s1.pgmi.index') }}" class="hover:underline">Pendidikan Guru Madrasah Ibtidaiyah (PGMI)</a></li>
                        <li><a href="{{ route('alumni.s1.piaud.index') }}" class="hover:underline">Pendidikan Islam Anak Usia Dini (PIAUD)</a></li>
                        <li><a href="{{ route('alumni.s1.mpi.index') }}" class="hover:underline">Manajemen Pendidikan Islam (MPI)</a></li>
                        <li><a href="{{ route('alumni.s1.bkpi.index') }}" class="hover:underline">Bimbingan dan Konseling Pendidikan Islam (BKPI)</a></li>
                    </ul>
                </div>

                <!-- FEBI -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <h4 class="font-bold text-green-700">Fakultas Ekonomi & Bisnis Islam</h4>
                    <ul class="ml-5 mt-2 list-disc text-gray-700 space-y-1">
                        <li><a href="{{ route('alumni.s1.eksyar.index') }}" class="hover:underline">Ekonomi Syari'ah (Eksyar)</a></li>
                    </ul>
                </div>

                <!-- Syariah & Hukum -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <h4 class="font-bold text-green-700">Fakultas Syariah & Hukum</h4>
                    <ul class="ml-5 mt-2 list-disc text-gray-700 space-y-1">
                        <li><a href="{{ route('alumni.s1.as.index') }}" class="hover:underline">Hukum Keluarga Islam (AS)</a></li>
                        <li><a href="{{ route('alumni.s1.htn.index') }}" class="hover:underline">Hukum Tata Negara (HTN)</a></li>
                    </ul>
                </div>

            </div>
        </div>

        <!-- ==================== S2 ==================== -->
        <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-lg transition">
            <h3 class="text-2xl font-bold text-green-700 mb-4">S2</h3>
            <button onclick="toggleMenu('fakultasS2')" 
                class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold px-6 py-2 rounded-full transition">
                Lihat Program Studi
            </button>

            <div id="fakultasS2" class="hidden mt-6 bg-gray-50 p-4 rounded-lg shadow-sm text-left">
                <ul class="ml-5 list-disc text-gray-700 space-y-1">
                    <li><a href="{{ route('alumni.s2.pai.index') }}" class="hover:underline">Pendidikan Agama Islam (PAI)</a></li>
                </ul>
            </div>
        </div>

    </div>
</section>

<script>
function toggleMenu(id) {
    document.getElementById(id).classList.toggle('hidden');
}
</script>

@endsection

