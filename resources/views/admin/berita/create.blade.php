@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-8">
    <div class="bg-white shadow-2xl rounded-3xl p-8 border border-gray-100">
        <div class="flex items-center mb-8">
            <a href="{{ route('admin.berita.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-2">Tambah Berita Baru</h1>
        <p class="text-gray-600 mb-8">Isi informasi berita terbaru untuk alumni IAIT.</p>

        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Gambar -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Berita (Opsional)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:border-green-400 transition-colors">
                    <input type="file" name="gambar" accept="image/*" class="hidden" id="gambar"
                           onchange="previewGambar(event)">
                    <label for="gambar" class="cursor-pointer flex flex-col items-center space-y-4">
                        <img id="previewImg" src="" alt="Preview"
                             class="hidden w-48 h-48 object-cover rounded-xl shadow-md">
                        <i id="uploadIcon" class="bi bi-cloud-upload text-4xl text-gray-400 hover:text-green-500 transition-colors"></i>
                        <div>
                            <p class="text-lg font-semibold text-gray-900">Klik untuk upload gambar</p>
                            <p class="text-sm text-gray-500">JPG, PNG max 2MB</p>
                        </div>
                    </label>
                </div>
                @error('gambar')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Judul -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Berita *</label>
                <input type="text" name="judul" value="{{ old('judul') }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('judul') border-red-300 @enderror"
                       placeholder="Masukkan judul berita yang menarik...">
                @error('judul')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Publikasi</label>
                <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>

            <!-- Isi -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Berita *</label>
                <textarea name="isi" rows="12" required
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('isi') border-red-300 @enderror"
                          placeholder="Tulis isi berita lengkap...">{{ old('isi') }}</textarea>
                @error('isi')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit"
                        class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all focus:outline-none focus:ring-4 focus:ring-green-200">
                    <i class="bi bi-check-lg me-2"></i>Publikasikan Berita
                </button>
                <a href="{{ route('admin.berita.index') }}"
                   class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-4 px-8 rounded-xl text-center shadow-lg hover:shadow-md transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function previewGambar(event) {
        const file = event.target.files[0];
        if (!file) return;
        const preview = document.getElementById('previewImg');
        const icon = document.getElementById('uploadIcon');
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
        icon.classList.add('hidden');
    }
</script>
@endsection