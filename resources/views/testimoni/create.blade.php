@extends('layouts.app')

@section('title', 'Tambah Testimoni')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_340px] gap-8 items-start">
        <div>
            <a href="{{ route('testimoni.index') }}" class="text-sm text-gray-500 hover:text-green-700 font-semibold">Kembali ke testimoni</a>
            <h1 class="text-3xl font-bold text-gray-900 mt-3">Bagikan Testimoni</h1>
            <p class="text-gray-500 mt-2">Tulis cerita yang spesifik, jujur, dan bermanfaat untuk calon mahasiswa maupun alumni lain.</p>

            @if(session('info'))
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl mt-6 text-sm">
                    {{ session('info') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mt-6 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <div>- {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('testimoni.store') }}" enctype="multipart/form-data"
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-6 mt-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
                        <input type="text" value="{{ $alumni->nama ?? auth()->user()->name }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm bg-gray-50 text-gray-500" readonly disabled>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jurusan / Prodi</label>
                        <input type="text" value="{{ $alumni->prodi ?? '-' }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm bg-gray-50 text-gray-500" readonly disabled>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun Lulus</label>
                        <input type="text" value="{{ $alumni->lulusan ?? '-' }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm bg-gray-50 text-gray-500" readonly disabled>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Pekerjaan Saat Ini</label>
                        <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $alumni->pekerjaan ?? '') }}"
                            placeholder="Contoh: Guru, Founder, Software Engineer"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Instansi / Perusahaan</label>
                        <input type="text" name="perusahaan" value="{{ old('perusahaan', $alumni->perusahaan ?? '') }}"
                            placeholder="Contoh: MA Al-Hikmah, PT Nusantara"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Isi Testimoni <span class="text-red-500">*</span></label>
                    <textarea name="isi_testimoni" rows="8" required maxlength="2000"
                        placeholder="Ceritakan pengalaman kuliah, skill yang terbentuk, dukungan kampus, dan dampaknya untuk karier atau kontribusi Anda sekarang..."
                        class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none resize-y">{{ old('isi_testimoni') }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Maksimal 2000 karakter. Testimoni akan direview admin sebelum tampil publik.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Profil (opsional)</label>
                    <input type="file" name="foto" accept="image/*"
                        class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 file:text-green-700 file:font-semibold hover:file:bg-green-100 cursor-pointer border border-gray-200 rounded-lg p-2">
                    <p class="text-xs text-gray-400 mt-1">Gunakan foto wajah profesional. Maksimal 2MB, format JPG/PNG.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <a href="{{ route('testimoni.index') }}"
                        class="sm:w-40 text-center border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold py-2.5 rounded-lg text-sm transition">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg text-sm transition">
                        Kirim untuk Review
                    </button>
                </div>
            </form>
        </div>

        <aside class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm lg:sticky lg:top-24">
            <h2 class="font-bold text-gray-900">Alur Testimoni</h2>
            <div class="mt-5 space-y-4 text-sm">
                <div class="flex gap-3">
                    <span class="w-7 h-7 rounded-full bg-green-50 text-green-700 font-bold flex items-center justify-center shrink-0">1</span>
                    <div>
                        <div class="font-semibold text-gray-800">Alumni mengirim cerita</div>
                        <p class="text-gray-500 mt-0.5">Data nama, prodi, dan tahun lulus diambil dari profil alumni.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <span class="w-7 h-7 rounded-full bg-amber-50 text-amber-700 font-bold flex items-center justify-center shrink-0">2</span>
                    <div>
                        <div class="font-semibold text-gray-800">Admin mereview</div>
                        <p class="text-gray-500 mt-0.5">Admin bisa menyetujui atau memberi alasan revisi.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <span class="w-7 h-7 rounded-full bg-blue-50 text-blue-700 font-bold flex items-center justify-center shrink-0">3</span>
                    <div>
                        <div class="font-semibold text-gray-800">Tampil publik</div>
                        <p class="text-gray-500 mt-0.5">Hanya testimoni approved yang tampil di galeri.</p>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
