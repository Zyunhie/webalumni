@extends('layouts.app')

@section('title', 'Ajukan Lowongan')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Ajukan Lowongan Kerja</h1>
    <p class="text-sm text-gray-500 mb-6">Lowongan yang kamu ajukan akan ditinjau admin sebelum ditampilkan ke publik.</p>

    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-6 text-sm text-yellow-800">
        ⚠️ Status awal lowongan adalah <strong>Menunggu Review</strong>. Admin akan menyetujui atau menolak pengajuan kamu.
    </div>

    @if($errors->any())
        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800 border border-red-200">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('alumni.lowongan.store') }}" method="POST"
          enctype="multipart/form-data"
          class="space-y-5 bg-white p-6 rounded-xl shadow-md">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Lowongan <span class="text-red-500">*</span></label>
            <input type="text" name="judul" value="{{ old('judul') }}" required
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Perusahaan <span class="text-red-500">*</span></label>
            <input type="text" name="perusahaan" value="{{ old('perusahaan') }}" required
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
            <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Pekerjaan</label>
            <textarea name="deskripsi" rows="4"
                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">{{ old('deskripsi') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kualifikasi</label>
            <textarea name="kualifikasi" rows="4"
                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">{{ old('kualifikasi') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Cara Melamar</label>
            <textarea name="cara_melamar" rows="3"
                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">{{ old('cara_melamar') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Link Eksternal <span class="text-gray-400">(opsional)</span></label>
            <input type="url" name="external_link" value="{{ old('external_link') }}" placeholder="https://..."
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
        </div>

        {{-- Field Gambar --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Lowongan <span class="text-gray-400">(opsional, maks 2MB)</span></label>
            <input type="file" name="gambar" accept="image/jpg,image/jpeg,image/png,image/webp"
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                   onchange="previewGambar(event)">
            <div id="preview-container" class="mt-3 hidden">
                <img id="preview-gambar" src="#" alt="Preview" class="h-40 object-cover rounded-lg border border-gray-200">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Target Prodi <span class="text-red-500">*</span></label>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                @foreach($prodis as $prodi)
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="target_prodi[]" value="{{ $prodi }}"
                               {{ in_array($prodi, old('target_prodi', [])) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <span class="text-sm text-gray-700 uppercase">{{ $prodi }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-2">
            <a href="{{ route('lowongan.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Batal</a>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-700 transition">
                Ajukan Lowongan
            </button>
        </div>
    </form>
</div>

<script>
function previewGambar(event) {
    const file = event.target.files[0];
    if (!file) return;
    const container = document.getElementById('preview-container');
    const img = document.getElementById('preview-gambar');
    img.src = URL.createObjectURL(file);
    container.classList.remove('hidden');
}
</script>
@endsection