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
            <button onclick="toggleCollapse('s1')" 
                class="toggle-btn-s1 bg-yellow-500 hover:bg-yellow-400 text-white font-semibold px-6 py-2 rounded-full transition">
                Lihat Fakultas
            </button>

            <!-- Daftar Fakultas S1 -->
            <div id="fakultasS1" class="relative mt-6 text-left">
                <div id="contentS1" class="collapsible-content max-h-48 overflow-hidden transition-all duration-300">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm space-y-4">
                        <!-- Fakultas Tarbiyah -->
                        <div>
                            <h4 class="font-bold text-green-700">Fakultas Tarbiyah</h4>
                            <ul class="ml-5 mt-2 list-disc text-gray-700 space-y-1">
                                <li><a href="{{ route('alumni.s1.pai.index') }}" class="alumni-link disabled-link">Pendidikan Agama Islam (PAI)</a></li>
                                <li><a href="{{ route('alumni.s1.pgmi.index') }}" class="alumni-link disabled-link">Pendidikan Guru Madrasah Ibtidaiyah (PGMI)</a></li>
                                <li><a href="{{ route('alumni.s1.piaud.index') }}" class="alumni-link disabled-link">Pendidikan Islam Anak Usia Dini (PIAUD)</a></li>
                                <li><a href="{{ route('alumni.s1.mpi.index') }}" class="alumni-link disabled-link">Manajemen Pendidikan Islam (MPI)</a></li>
                                <li><a href="{{ route('alumni.s1.bkpi.index') }}" class="alumni-link disabled-link">Bimbingan dan Konseling Pendidikan Islam (BKPI)</a></li>
                            </ul>
                        </div>
                        <!-- FEBI -->
                        <div>
                            <h4 class="font-bold text-green-700">Fakultas Ekonomi & Bisnis Islam</h4>
                            <ul class="ml-5 mt-2 list-disc text-gray-700 space-y-1">
                                <li><a href="{{ route('alumni.s1.eksyar.index') }}" class="alumni-link disabled-link">Ekonomi Syari'ah (Eksyar)</a></li>
                            </ul>
                        </div>
                        <!-- Syariah & Hukum -->
                        <div>
                            <h4 class="font-bold text-green-700">Fakultas Syariah & Hukum</h4>
                            <ul class="ml-5 mt-2 list-disc text-gray-700 space-y-1">
                                <li><a href="{{ route('alumni.s1.as.index') }}" class="alumni-link disabled-link">Hukum Keluarga Islam (AS)</a></li>
                                <li><a href="{{ route('alumni.s1.htn.index') }}" class="alumni-link disabled-link">Hukum Tata Negara (HTN)</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Efek gradien pudar -->
                <div id="fadeS1" class="fade-gradient absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white via-white to-transparent pointer-events-none"></div>
            </div>
        </div>

        <!-- ==================== S2 ==================== -->
        <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-lg transition">
            <h3 class="text-2xl font-bold text-green-700 mb-4">S2</h3>
            <button onclick="toggleCollapse('s2')" 
                class="toggle-btn-s2 bg-yellow-500 hover:bg-yellow-400 text-white font-semibold px-6 py-2 rounded-full transition">
                Lihat Program Studi
            </button>

            <div id="fakultasS2" class="relative mt-6 text-left">
                <div id="contentS2" class="collapsible-content max-h-48 overflow-hidden transition-all duration-300">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <ul class="ml-5 list-disc text-gray-700 space-y-1">
                            <li><a href="{{ route('alumni.s2.pai.index') }}" class="alumni-link disabled-link">Pendidikan Agama Islam (PAI)</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Efek gradien pudar -->
                <div id="fadeS2" class="fade-gradient absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white via-white to-transparent pointer-events-none"></div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Link disabled (awal) */
    .alumni-link.disabled-link {
        pointer-events: none;
        opacity: 0.5;
        color: #6b7280;
        text-decoration: none;
        cursor: default;
    }
    /* Link aktif: tanpa underline, hanya hover berubah warna */
    .alumni-link:not(.disabled-link) {
        pointer-events: auto;
        opacity: 1;
        color: #374151;
        text-decoration: none;
        cursor: pointer;
        transition: color 0.2s;
    }
    .alumni-link:not(.disabled-link):hover {
        color: #15803d;
        text-decoration: none;
    }

    /* Gradien dan animasi */
    .bg-gradient-to-t.from-white {
        --tw-gradient-from: #ffffff;
        --tw-gradient-to: rgba(255,255,255,0);
        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
    }
    .collapsible-content {
        transition: max-height 0.3s ease-out;
    }
    .collapsible-content.expanded {
        max-height: 2000px;
    }
</style>

<script>
function toggleCollapse(level) {
    const content = document.getElementById(`content${level.toUpperCase()}`);
    const fade = document.getElementById(`fade${level.toUpperCase()}`);
    const btn = document.querySelector(`.toggle-btn-${level}`);
    const links = content.querySelectorAll('.alumni-link');
    
    if (!content || !fade || !btn) return;
    
    const isExpanded = content.classList.contains('expanded');
    
    if (isExpanded) {
        // Menutup: sembunyikan konten, tampilkan gradien, ubah teks tombol, nonaktifkan link
        content.classList.remove('expanded');
        fade.style.display = 'block';
        btn.textContent = level === 's1' ? 'Lihat Fakultas' : 'Lihat Program Studi';
        links.forEach(link => link.classList.add('disabled-link'));
        
        // Scroll ke ATAS (ke tombol)
        btn.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        // Membuka: tampilkan semua konten, hilangkan gradien, ubah teks tombol, aktifkan link
        content.classList.add('expanded');
        fade.style.display = 'none';
        btn.textContent = level === 's1' ? 'Sembunyikan Fakultas' : 'Sembunyikan Program Studi';
        links.forEach(link => link.classList.remove('disabled-link'));
        
        // Scroll ke BAWAH (ke konten)
        content.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}
</script>

@endsection