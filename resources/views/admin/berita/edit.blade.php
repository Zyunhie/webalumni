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

        {{-- FORM UPDATE (PUT) --}}
        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Gambar Preview -->
            <div class="text-center">
                @if($berita->gambar)
                    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-32 h-32 object-cover rounded-2xl mx-auto shadow-lg mb-4">
                    <p class="text-sm text-gray-500 mb-4">Gambar saat ini</p>
                @endif
                
                <!-- Upload Baru -->
                <label class="block text-sm font-semibold text-gray-700 mb-2">Ganti Gambar (Opsional)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 text-center hover:border-green-400 transition-colors">
                    <input type="file" name="gambar" accept="image/*" class="hidden" id="gambar">
                    <label for="gambar" class="cursor-pointer flex flex-col items-center space-y-4">
                        <i class="bi bi-cloud-upload text-3xl text-gray-400 hover:text-green-500 transition-colors"></i>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Ganti dengan gambar baru</p>
                            <p class="text-xs text-gray-500">JPG, PNG max 2MB (kosongkan jika tetap gambar lama)</p>
                        </div>
                    </label>
                    @error('gambar')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
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
                <input type="date" name="tanggal" value="{{ old('tanggal', $berita->tanggal ? \Carbon\Carbon::parse($berita->tanggal)->format('Y-m-d') : '') }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>

            <!-- Isi Berita -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Berita *</label>
                <textarea name="isi" rows="12" required 
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('isi') border-red-300 @enderror"
                          placeholder="Tulis isi berita lengkap...">{{ old('isi', $berita->isi) }}</textarea>
                @error('isi')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Update & Batal --}}
            <div class="flex gap-4 pt-6">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all focus:outline-none focus:ring-4 focus:ring-blue-200">
                    <i class="bi bi-check-lg me-2"></i>
                    Update Berita
                </button>
                <a href="{{ route('admin.berita.index') }}" 
                   class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-4 px-8 rounded-xl text-center shadow-lg hover:shadow-md transition-all">
                    Batal
                </a>
            </div>
        </form>

        {{-- FORM DELETE (terpisah & jelas di bawah) --}}
        <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-sm text-red-600 mb-3 flex items-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Tindakan berbahaya: Hapus berita secara permanen.
            </p>
            <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" onsubmit="return confirm('Yakin hapus berita ini? Tindakan tidak dapat dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all">
                    <i class="bi bi-trash me-2"></i>Hapus Berita Permanen
                </button>
            </form>
        </div>
    </div>
</div>
@endsection