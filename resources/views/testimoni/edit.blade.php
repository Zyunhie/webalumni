@extends('layouts.app')

@section('title', 'Edit Testimoni')

@section('content')
<section class="max-w-2xl mx-auto px-6 py-12">
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Edit Testimoni</h1>
        <p class="text-xl text-gray-600">Update testimoni Anda</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-8">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FIX: form tag lengkap + enctype wajib untuk file upload --}}
    <form method="POST" action="{{ route('testimoni.update', $testimoni) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Nama Lengkap -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                {{-- FIX: semua variabel konsisten pakai $testimoni --}}
                <input type="text" name="nama" value="{{ old('nama', $testimoni->nama) }}" required
                       class="w-full px-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition text-lg">
            </div>

            <!-- Jurusan -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jurusan/Program Studi <span class="text-red-500">*</span></label>
                <input type="text" name="jurusan" value="{{ old('jurusan', $testimoni->jurusan) }}" required
                       class="w-full px-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition text-lg">
            </div>

            <!-- Tahun Lulus -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Lulus <span class="text-red-500">*</span></label>
                <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus', $testimoni->tahun_lulus) }}" min="1900" max="2100" required
                       class="w-full px-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition text-lg">
            </div>

            <!-- Pekerjaan -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pekerjaan Saat Ini</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $testimoni->pekerjaan) }}"
                       class="w-full px-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition text-lg">
            </div>

            <!-- Perusahaan -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tempat Kerja/Perusahaan</label>
                <input type="text" name="perusahaan" value="{{ old('perusahaan', $testimoni->perusahaan) }}"
                       class="w-full px-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition text-lg">
            </div>

            <!-- Foto -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Profil</label>

                {{-- FIX: Preview foto existing yang sudah tersimpan --}}
                <div id="foto-preview-wrapper" class="{{ $testimoni->foto ? '' : 'hidden' }} mb-4 p-4 bg-gray-50 rounded-xl border-2 border-dashed border-green-300 text-center">
                    <img id="foto-preview"
                         src="{{ $testimoni->foto ? Storage::url($testimoni->foto) : '' }}"
                         alt="Foto saat ini"
                         class="w-32 h-32 object-cover rounded-2xl mx-auto">
                    <p class="text-sm text-gray-500 mt-2" id="foto-label">
                        {{ $testimoni->foto ? 'Foto saat ini' : '' }}
                    </p>
                    <button type="button" id="foto-remove" class="text-xs text-red-500 hover:text-red-700 mt-1">× Ganti foto</button>
                </div>

                <div id="foto-dropzone" class="{{ $testimoni->foto ? 'hidden' : '' }} border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:border-green-400 transition cursor-pointer group">
                    <input type="file" name="foto" accept="image/*" class="hidden" id="foto-upload">
                    <label for="foto-upload" class="cursor-pointer">
                        <div class="group-hover:text-green-600 transition">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p class="text-lg font-semibold text-gray-700 group-hover:text-green-600">Ganti foto baru (opsional)</p>
                            <p class="text-sm text-gray-500 mt-1">JPG, PNG max 2MB</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Isi Testimoni -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Testimoni Anda <span class="text-red-500">*</span></label>
                <textarea name="isi_testimoni" rows="8" required
                          class="w-full px-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition text-lg resize-vertical">{{ old('isi_testimoni', $testimoni->isi_testimoni) }}</textarea>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 mt-12 pt-8 border-t border-gray-200">
            <a href="{{ route('testimoni.index') }}" class="flex-1 sm:flex-none bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold px-8 py-4 rounded-xl text-center transition">
                ← Kembali ke Galeri
            </a>
            <button type="submit" class="flex-1 sm:flex-none bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                Update & Kirim Ulang Review
            </button>
        </div>
    </form>
</section>

<script>
    const fotoUpload   = document.getElementById('foto-upload');
    const fotoPreview  = document.getElementById('foto-preview');
    const fotoWrapper  = document.getElementById('foto-preview-wrapper');
    const fotoDropzone = document.getElementById('foto-dropzone');
    const fotoLabel    = document.getElementById('foto-label');
    const fotoRemove   = document.getElementById('foto-remove');

    fotoUpload.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            fotoPreview.src          = e.target.result;
            fotoLabel.textContent    = file.name;
            fotoWrapper.classList.remove('hidden');
            fotoDropzone.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });

    fotoRemove.addEventListener('click', function () {
        fotoUpload.value         = '';
        fotoPreview.src          = '';
        fotoLabel.textContent    = '';
        fotoWrapper.classList.add('hidden');
        fotoDropzone.classList.remove('hidden');
    });
</script>
@endsection