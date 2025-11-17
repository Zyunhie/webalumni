@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Tombol Kirim CV di pojok kanan atas -->
        <div class="flex justify-end mb-6">
            <button onclick="openFormulir()" 
                class="inline-block bg-yellow-500 hover:bg-yellow-400 text-white font-bold py-2 px-6 rounded-lg transition">
                Kirim CV-mu Sekarang
            </button>
        </div>

        <!-- Konten Utama -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                @if($lowongan->gambar)
                    <img src="{{ asset($lowongan->gambar) }}" alt="{{ $lowongan->judul }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                        No Image Available
                    </div>
                @endif
            </div>

            <div class="lg:col-span-2 space-y-8">
                <h1 class="text-3xl font-extrabold text-green-700">Detail</h1>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4 text-green-700">Detail Lowongan Pekerjaan</h2>
                    <div class="space-y-2 text-gray-700">
                        <p><strong>Lokasi:</strong> {{ $lowongan->lokasi ?? 'Indonesia' }}</p>
                        <p><strong>Tanggal Posting:</strong> {{ \Carbon\Carbon::parse($lowongan->tanggal_post ?? now())->format('d-m-Y') }}</p>
                        <p><strong>Alamat:</strong> {{ $lowongan->alamat ?? 'Komp. Patra II No.46, Jakarta Pusat' }}</p>
                        <p><strong>Batas Lamaran:</strong> {{ $lowongan->batas_lamaran ? \Carbon\Carbon::parse($lowongan->batas_lamaran)->format('d-m-Y') : '-' }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4 text-green-700">Profil Perusahaan</h2>
                    <h3 class="text-2xl font-bold mb-3">{{ $lowongan->perusahaan ?? 'Perbarindo Indonesia' }}</h3>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $lowongan->profile_perusahaan ?? 'Perbarindo adalah organisasi yang menaungi BPR dan BPRS di Indonesia sejak 1995 berfokus pada penguatan daya saing dan profesionalisme perbankan rakyat.' }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4 text-green-700">Deskripsi Pekerjaan</h2>
                    <div class="text-gray-700 leading-relaxed">
                        {!! nl2br(e($lowongan->deskripsi)) !!}
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('lowongan.index') }}" 
                        class="inline-block bg-gray-500 text-white px-6 py-2 rounded-full hover:bg-gray-400 transition">
                        ← Kembali ke Lowongan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popup Formulir Lamaran -->
<div id="formulirOverlay" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden z-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-3xl mx-4 rounded-2xl shadow-2xl p-8 relative animate-fadeIn overflow-y-auto max-h-[90vh]">
        <button onclick="closeFormulir()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl">✕</button>

        <h2 class="text-3xl font-bold text-center text-green-700 mb-2">Lamaran Pekerjaan</h2>
        <p class="text-center text-gray-600 mb-6">Harap lengkapi formulir berikut untuk melamar posisi di kantor kami.</p>

        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <!-- Nama Lengkap -->
            <div>
                <label class="font-semibold text-gray-700 block mb-2">Nama Lengkap</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <input type="text" name="nama_depan" placeholder="Nama Depan" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    <input type="text" name="nama_tengah" placeholder="Nama Tengah" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    <input type="text" name="nama_belakang" placeholder="Nama Belakang" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                </div>
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <label class="font-semibold text-gray-700 block mb-2">Tanggal Lahir</label>
                <div class="grid grid-cols-3 gap-3">
                    <input type="number" name="bulan" placeholder="Bulan" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    <input type="number" name="hari" placeholder="Hari" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    <input type="number" name="tahun" placeholder="Tahun" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                </div>
            </div>

            <!-- Alamat -->
            <div>
                <label class="font-semibold text-gray-700 block mb-2">Alamat Saat Ini</label>
                <input type="text" name="alamat_1" placeholder="Alamat Jalan" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 mb-2">
                <input type="text" name="alamat_2" placeholder="Alamat Jalan Baris ke-2" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 mb-2">
                <div class="grid grid-cols-2 gap-3 mb-2">
                    <input type="text" name="kota" placeholder="Kabupaten / Kota" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    <input type="text" name="provinsi" placeholder="Provinsi" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                </div>
                <input type="text" name="kode_pos" placeholder="Kode Pos" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Kontak -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700 block mb-1">Alamat Email</label>
                    <input type="email" name="email" placeholder="contoh@contoh.com" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="font-semibold text-gray-700 block mb-1">Nomor Telepon</label>
                    <input type="text" name="telepon" placeholder="(000) 000-0000" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                </div>
            </div>

            <!-- LinkedIn -->
            <div>
                <label class="font-semibold text-gray-700 block mb-1">LinkedIn</label>
                <input type="url" name="linkedin" placeholder="https://linkedin.com/in/username" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Posisi dan Sumber -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700 block mb-1">Posisi yang Dilamar</label>
                    <select name="posisi" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                        <option>Silahkan Pilih</option>
                        <option>Frontend Developer</option>
                        <option>Backend Developer</option>
                        <option>UI/UX Designer</option>
                        <option>Marketing</option>
                    </select>
                </div>
                <div>
                    <label class="font-semibold text-gray-700 block mb-1">Dari mana Anda mengetahui tentang kami?</label>
                    <select name="sumber_info" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                        <option>Silahkan Pilih</option>
                        <option>Website</option>
                        <option>Media Sosial</option>
                        <option>Teman / Alumni</option>
                        <option>Lainnya</option>
                    </select>
                </div>
            </div>

            <!-- Tanggal Siap Bekerja -->
            <div>
                <label class="font-semibold text-gray-700 block mb-1">Tanggal Siap Bekerja</label>
                <input type="date" name="tanggal_mulai" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Upload Resume -->
            <div>
                <label class="font-semibold text-gray-700 block mb-1">Unggah Resume Anda</label>
                <input type="file" name="resume" accept=".pdf,.doc,.docx" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Surat Pengantar -->
            <div>
                <label class="font-semibold text-gray-700 block mb-1">Surat Pengantar</label>
                <textarea name="surat_pengantar" placeholder="Ketik disini..." rows="4" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"></textarea>
            </div>

            <div class="text-center pt-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-full font-semibold shadow-md">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn { animation: fadeIn 0.3s ease-out; }
</style>

<script>
function openFormulir() {
    document.getElementById('formulirOverlay').classList.remove('hidden');
}
function closeFormulir() {
    document.getElementById('formulirOverlay').classList.add('hidden');
}
// klik area luar untuk menutup form
document.addEventListener('click', function(e) {
    const overlay = document.getElementById('formulirOverlay');
    const modal = overlay?.querySelector('.bg-white');
    if (overlay && !modal.contains(e.target) && !e.target.closest('button[onclick="openFormulir()"]')) {
        closeFormulir();
    }
});
</script>
@endsection
