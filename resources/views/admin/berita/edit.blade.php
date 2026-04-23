@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-8">
    <div class="bg-white shadow-2xl rounded-3xl p-8 border border-gray-100">
        <div class="flex items-center mb-8">
            <a href="{{ route('admin.berita.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
            </a>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Berita</h1>
        <p class="text-gray-600 mb-8">Update informasi berita untuk alumni IAIT.</p>

        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Gambar -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Ganti Gambar (Opsional)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 text-center hover:border-green-400 transition-colors">
                    <input type="file" name="gambar" accept="image/*" class="hidden" id="gambar"
                           onchange="previewGambar(event)">
                    <label for="gambar" class="cursor-pointer flex flex-col items-center space-y-3">
                        <img id="previewImg"
                             src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : '' }}"
                             alt="Preview"
                             class="{{ $berita->gambar ? '' : 'hidden' }} w-48 h-48 object-cover rounded-xl shadow-md">
                        <i id="uploadIcon" class="bi bi-cloud-upload text-3xl text-gray-400 hover:text-green-500 transition-colors {{ $berita->gambar ? 'hidden' : '' }}"></i>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $berita->gambar ? 'Klik untuk ganti gambar' : 'Klik untuk upload gambar' }}
                            </p>
                            <p class="text-xs text-gray-500">JPG, PNG max 2MB — kosongkan jika tetap pakai gambar lama</p>
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
                <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('judul') border-red-300 @enderror">
                @error('judul')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Publikasi</label>
                <input type="date" name="tanggal"
                       value="{{ old('tanggal', $berita->tanggal ? \Carbon\Carbon::parse($berita->tanggal)->format('Y-m-d') : '') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>

            <!-- Isi -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Berita *</label>
                <textarea name="isi" rows="12" required
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('isi') border-red-300 @enderror"
                          placeholder="Tulis isi berita lengkap...">{{ old('isi', $berita->isi) }}</textarea>
                @error('isi')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-6">
                <button type="submit"
                        class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all focus:outline-none focus:ring-4 focus:ring-blue-200">
                    <i class="bi bi-check-lg me-2"></i>Update Berita
                </button>
                <a href="{{ route('admin.berita.index') }}"
                   class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-4 px-8 rounded-xl text-center shadow-lg hover:shadow-md transition-all">
                    Batal
                </a>
            </div>
        </form>

        <!-- Delete -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-sm text-red-600 mb-3 flex items-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Tindakan berbahaya: Hapus berita secara permanen.
            </p>
            <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST"
                  onsubmit="return confirm('Yakin hapus berita ini? Tindakan tidak dapat dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all">
                    <i class="bi bi-trash me-2"></i>Hapus Berita Permanen
                </button>
            </form>
        </div>
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