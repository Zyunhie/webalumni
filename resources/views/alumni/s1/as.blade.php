@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative h-[300px] flex items-center justify-center text-center text-white bg-cover bg-center"
    style="background-image: url('{{ asset('images/Branda.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center text-white">
        <h1 class="text-4xl font-bold">Pendidikan Guru Madrasah Ibtidaiyah (PGMI)</h1>
        <p class="mt-2 text-sm">
            <a href="{{ route('dashboard') }}" class="hover:underline">Beranda</a> > 
            <a href="{{ route('alumni.data') }}" class="hover:underline">Data Alumni</a> > 
            <span>PGMI</span>
        </p>
    </div>
</section>

<!-- Konten Utama -->
<section class="max-w-6xl mx-auto px-6 py-12">
    <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Data Alumni Prodi HKI</h2>

    <!-- Dropdown Pilihan Tahun -->
    <div class="flex justify-center mb-10">
        <select id="tahunSelect" onchange="filterTahun()" 
            class="border border-gray-300 rounded-full px-6 py-2 text-gray-700 focus:ring-green-500 focus:border-green-500 shadow-sm max-h-48 overflow-y-auto">
            <option value="">-- Pilih Tahun --</option>
            @for ($i = date('Y'); $i >= 2000; $i--)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    </div>

    <!-- Pesan Saat Belum Pilih Tahun -->
    <div id="infoMessage" class="text-center text-gray-500 italic mb-6">
        Silakan pilih tahun terlebih dahulu untuk melihat data alumni.
    </div>

    <!-- Daftar Alumni -->
    <div id="alumniContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
        <div class="alumni-card" data-tahun="2020">
            <div class="bg-white rounded-xl shadow-md flex items-center space-x-4 p-4 hover:shadow-lg transition">
                <img src="{{ asset('images/K.jpeg') }}" class="w-16 h-16 rounded-full object-cover" alt="Alumni">
                <div>
                    <h3 class="font-semibold text-gray-800">Rizky Nurhidayat</h3>
                    <p class="text-gray-600 text-sm">PGMI</p>
                    <p class="text-gray-500 text-xs">Angkatan 2020</p>
                </div>
            </div>
        </div>

        <div class="alumni-card" data-tahun="2021">
            <div class="bg-white rounded-xl shadow-md flex items-center space-x-4 p-4 hover:shadow-lg transition">
                <img src="{{ asset('images/K.jpeg') }}" class="w-16 h-16 rounded-full object-cover" alt="Alumni">
                <div>
                    <h3 class="font-semibold text-gray-800">Intan Puspitasari</h3>
                    <p class="text-gray-600 text-sm">PGMI</p>
                    <p class="text-gray-500 text-xs">Angkatan 2021</p>
                </div>
            </div>
        </div>

        <div class="alumni-card" data-tahun="2022">
            <div class="bg-white rounded-xl shadow-md flex items-center space-x-4 p-4 hover:shadow-lg transition">
                <img src="{{ asset('images/K.jpeg') }}" class="w-16 h-16 rounded-full object-cover" alt="Alumni">
                <div>
                    <h3 class="font-semibold text-gray-800">Ahmad Rofi</h3>
                    <p class="text-gray-600 text-sm">PGMI</p>
                    <p class="text-gray-500 text-xs">Angkatan 2022</p>
                </div>
            </div>
        </div>

        <div class="alumni-card" data-tahun="2023">
            <div class="bg-white rounded-xl shadow-md flex items-center space-x-4 p-4 hover:shadow-lg transition">
                <img src="{{ asset('images/K.jpeg') }}" class="w-16 h-16 rounded-full object-cover" alt="Alumni">
                <div>
                    <h3 class="font-semibold text-gray-800">Dewi Ayuningtyas</h3>
                    <p class="text-gray-600 text-sm">PGMI</p>
                    <p class="text-gray-500 text-xs">Angkatan 2023</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-10">
        <a href="{{ route('alumni.data') }}" 
           class="inline-block bg-gray-500 hover:bg-gray-400 text-white px-6 py-2 rounded-full font-semibold transition">
           ← Kembali ke Data Alumni
        </a>
    </div>
</section>

<!-- Script Filter Tahun -->
<script>
function filterTahun() {
    const tahunSelect = document.getElementById('tahunSelect');
    const selectedTahun = tahunSelect.value;
    const cards = document.querySelectorAll('.alumni-card');
    const alumniContainer = document.getElementById('alumniContainer');
    const infoMessage = document.getElementById('infoMessage');

    if (selectedTahun === "") {
        alumniContainer.classList.add('hidden');
        infoMessage.textContent = "Silakan pilih tahun terlebih dahulu untuk melihat data alumni.";
        infoMessage.classList.remove('hidden');
        return;
    }

    // Setelah memilih tahun pertama kali
    alumniContainer.classList.remove('hidden');
    infoMessage.classList.add('hidden');

    // Hapus opsi "-- Pilih Tahun --" kalau masih ada
    const firstOption = tahunSelect.querySelector('option[value=""]');
    if (firstOption) {
        firstOption.remove();
    }

    // Tambahkan "Semua" kalau belum ada
    if (!document.getElementById('allOption')) {
        const allOption = document.createElement('option');
        allOption.value = "all";
        allOption.textContent = "Semua";
        allOption.id = "allOption";
        tahunSelect.insertBefore(allOption, tahunSelect.firstChild);
    }

    // Filter tampilan
    cards.forEach(card => {
        const tahun = card.getAttribute('data-tahun');
        card.style.display = (selectedTahun === "all" || tahun === selectedTahun) ? 'block' : 'none';
    });
}
</script>

<!-- Scrollbar Custom Style -->
<style>
    select {
        scrollbar-width: thin;
        scrollbar-color: #22c55e #f3f4f6;
    }
    select::-webkit-scrollbar {
        width: 8px;
    }
    select::-webkit-scrollbar-thumb {
        background-color: #22c55e;
        border-radius: 4px;
    }
    select::-webkit-scrollbar-track {
        background-color: #f3f4f6;
    }
</style>
@endsection
