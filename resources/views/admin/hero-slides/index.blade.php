@extends('layouts.app')

@section('title', 'Kelola Hero Carousel')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Hero Image</h1>
            <p class="text-gray-500 text-sm mt-1">Foto hero untuk berbagai halaman website</p>
        </div>
        <button onclick="openModal()"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition">
            + Tambah Foto
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- BERANDA --}}
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-4">
            <h2 class="text-lg font-bold text-gray-800">Beranda</h2>
            <span class="text-xs bg-green-100 text-green-700 font-semibold px-2.5 py-0.5 rounded-full">
                {{ isset($slides['home']) ? $slides['home']->count() : 0 }} slide
            </span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($slides['home'] ?? [] as $slide)
                @include('admin.hero-slides._card', ['slide' => $slide])
            @empty
                <div class="col-span-3 text-center py-10 text-gray-400 text-sm border-2 border-dashed border-gray-200 rounded-2xl">
                    Belum ada foto untuk beranda.
                </div>
            @endforelse
        </div>
    </div>

    {{-- TENTANG --}}
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-4">
            <h2 class="text-lg font-bold text-gray-800">Tentang</h2>
            <span class="text-xs bg-blue-100 text-blue-700 font-semibold px-2.5 py-0.5 rounded-full">
                {{ isset($slides['tentang']) ? $slides['tentang']->count() : 0 }} foto
            </span>
            <span class="text-xs text-gray-400">(hanya 1 foto yang dipakai)</span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($slides['tentang'] ?? [] as $slide)
                @include('admin.hero-slides._card', ['slide' => $slide])
            @empty
                <div class="col-span-3 text-center py-10 text-gray-400 text-sm border-2 border-dashed border-gray-200 rounded-2xl">
                    Belum ada foto untuk halaman tentang.
                </div>
            @endforelse
        </div>
    </div>

    {{-- ALUMNI --}}
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-4">
            <h2 class="text-lg font-bold text-gray-800">Alumni</h2>
            <span class="text-xs bg-yellow-100 text-yellow-700 font-semibold px-2.5 py-0.5 rounded-full">
                {{ isset($slides['alumni']) ? $slides['alumni']->count() : 0 }} foto
            </span>
            <span class="text-xs text-gray-400">(hanya 1 foto yang dipakai)</span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($slides['alumni'] ?? [] as $slide)
                @include('admin.hero-slides._card', ['slide' => $slide])
            @empty
                <div class="col-span-3 text-center py-10 text-gray-400 text-sm border-2 border-dashed border-gray-200 rounded-2xl">
                    Belum ada foto untuk halaman alumni.
                </div>
            @endforelse
        </div>
    </div>

    {{-- AGENDA --}}
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-4">
            <h2 class="text-lg font-bold text-gray-800">Agenda</h2>
            <span class="text-xs bg-orange-100 text-orange-700 font-semibold px-2.5 py-0.5 rounded-full">
                {{ isset($slides['agenda']) ? $slides['agenda']->count() : 0 }} foto
            </span>
            <span class="text-xs text-gray-400">(hanya 1 foto yang dipakai)</span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($slides['agenda'] ?? [] as $slide)
                @include('admin.hero-slides._card', ['slide' => $slide])
            @empty
                <div class="col-span-3 text-center py-10 text-gray-400 text-sm border-2 border-dashed border-gray-200 rounded-2xl">
                    Belum ada foto untuk halaman agenda.
                </div>
            @endforelse
        </div>
    </div>

    {{-- TESTIMONI --}}
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-4">
            <h2 class="text-lg font-bold text-gray-800">Testimoni</h2>
            <span class="text-xs bg-pink-100 text-pink-700 font-semibold px-2.5 py-0.5 rounded-full">
                {{ isset($slides['testimoni']) ? $slides['testimoni']->count() : 0 }} foto
            </span>
            <span class="text-xs text-gray-400">(hanya 1 foto yang dipakai)</span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($slides['testimoni'] ?? [] as $slide)
                @include('admin.hero-slides._card', ['slide' => $slide])
            @empty
                <div class="col-span-3 text-center py-10 text-gray-400 text-sm border-2 border-dashed border-gray-200 rounded-2xl">
                    Belum ada foto untuk halaman testimoni.
                </div>
            @endforelse
        </div>
    </div>

    {{-- BERITA --}}
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-4">
            <h2 class="text-lg font-bold text-gray-800">Berita</h2>
            <span class="text-xs bg-indigo-100 text-indigo-700 font-semibold px-2.5 py-0.5 rounded-full">
                {{ isset($slides['berita']) ? $slides['berita']->count() : 0 }} foto
            </span>
            <span class="text-xs text-gray-400">(hanya 1 foto yang dipakai)</span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($slides['berita'] ?? [] as $slide)
                @include('admin.hero-slides._card', ['slide' => $slide])
            @empty
                <div class="col-span-3 text-center py-10 text-gray-400 text-sm border-2 border-dashed border-gray-200 rounded-2xl">
                    Belum ada foto untuk halaman berita.
                </div>
            @endforelse
        </div>
    </div>

    {{-- LOWONGAN --}}
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-4">
            <h2 class="text-lg font-bold text-gray-800">Lowongan</h2>
            <span class="text-xs bg-purple-100 text-purple-700 font-semibold px-2.5 py-0.5 rounded-full">
                {{ isset($slides['lowongan']) ? $slides['lowongan']->count() : 0 }} foto
            </span>
            <span class="text-xs text-gray-400">(hanya 1 foto yang dipakai)</span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($slides['lowongan'] ?? [] as $slide)
                @include('admin.hero-slides._card', ['slide' => $slide])
            @empty
                <div class="col-span-3 text-center py-10 text-gray-400 text-sm border-2 border-dashed border-gray-200 rounded-2xl">
                    Belum ada foto untuk halaman lowongan.
                </div>
            @endforelse
        </div>
    </div>

    {{-- VERIFIKASI AKUN --}}
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-4">
            <h2 class="text-lg font-bold text-gray-800">Verifikasi Akun</h2>
            <span class="text-xs bg-gray-100 text-gray-700 font-semibold px-2.5 py-0.5 rounded-full">
                {{ isset($slides['verifikasi_akun']) ? $slides['verifikasi_akun']->count() : 0 }} foto
            </span>
            <span class="text-xs text-gray-400">(hanya 1 foto yang dipakai)</span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($slides['verifikasi_akun'] ?? [] as $slide)
                @include('admin.hero-slides._card', ['slide' => $slide])
            @empty
                <div class="col-span-3 text-center py-10 text-gray-400 text-sm border-2 border-dashed border-gray-200 rounded-2xl">
                    Belum ada foto untuk halaman verifikasi akun.
                </div>
            @endforelse
        </div>
    </div>

    {{-- KONTAK --}}
<div class="mb-10">
    <div class="flex items-center gap-3 mb-4">
        <h2 class="text-lg font-bold text-gray-800">Kontak</h2>
        <span class="text-xs bg-teal-100 text-teal-700 font-semibold px-2.5 py-0.5 rounded-full">
            {{ isset($slides['kontak']) ? $slides['kontak']->count() : 0 }} foto
        </span>
        <span class="text-xs text-gray-400">(hanya 1 foto yang dipakai)</span>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @forelse($slides['kontak'] ?? [] as $slide)
            @include('admin.hero-slides._card', ['slide' => $slide])
        @empty
            <div class="col-span-3 text-center py-10 text-gray-400 text-sm border-2 border-dashed border-gray-200 rounded-2xl">
                Belum ada foto untuk halaman kontak.
            </div>
        @endforelse
    </div>
</div>

    {{-- KELOLA USER --}}
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-4">
            <h2 class="text-lg font-bold text-gray-800">Kelola User</h2>
            <span class="text-xs bg-red-100 text-red-700 font-semibold px-2.5 py-0.5 rounded-full">
                {{ isset($slides['kelola_user']) ? $slides['kelola_user']->count() : 0 }} foto
            </span>
            <span class="text-xs text-gray-400">(hanya 1 foto yang dipakai)</span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($slides['kelola_user'] ?? [] as $slide)
                @include('admin.hero-slides._card', ['slide' => $slide])
            @empty
                <div class="col-span-3 text-center py-10 text-gray-400 text-sm border-2 border-dashed border-gray-200 rounded-2xl">
                    Belum ada foto untuk halaman kelola user.
                </div>
            @endforelse
        </div>
    </div>

</div>

{{-- MODAL TAMBAH / EDIT --}}
<div id="modal-overlay"
    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4"
    onclick="closeModalOnOverlay(event)">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md" onclick="event.stopPropagation()">

        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-800" id="modal-title">Tambah Foto</h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="modal-form" method="POST" enctype="multipart/form-data" class="px-6 py-5 space-y-4">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            {{-- Preview --}}
            <div id="img-preview-wrap" class="hidden">
                <img id="img-preview" src="" alt="preview"
                    class="w-full aspect-video object-cover rounded-xl border border-gray-200">
            </div>

            {{-- Upload --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    Foto <span class="text-red-400">*</span>
                </label>
                <input type="file" name="gambar" id="input-gambar" accept="image/*"
                    class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 file:text-green-700 file:font-semibold hover:file:bg-green-100 cursor-pointer border border-gray-200 rounded-xl p-2">
                <p class="text-xs text-gray-400 mt-1">Max 3MB. Format: JPG, PNG, WebP.</p>
            </div>

            {{-- Page selector --}}
            <div id="page-selector">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    Halaman <span class="text-red-400">*</span>
                </label>
                <select name="page" id="input-page"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none">
                    <option value="home">Beranda</option>
                    <option value="tentang">Tentang</option>
                    <option value="alumni">Alumni</option>
                    <option value="agenda">Agenda</option>
                    <option value="testimoni">Testimoni</option>
                    <option value="berita">Berita</option>
                    <option value="lowongan">Lowongan</option>
                    <option value="verifikasi_akun">Verifikasi Akun</option>
                    <option value="kontak">Kontak</option>
                    <option value="kelola_user">Kelola User</option>
                </select>
            </div>

            {{-- Aktif --}}
            <div class="flex items-center gap-3">
                <input type="checkbox" name="aktif" id="input-aktif" value="1"
                    class="w-4 h-4 accent-green-600 cursor-pointer">
                <label for="input-aktif" class="text-sm text-gray-600 cursor-pointer">Tampilkan foto ini</label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal()"
                    class="flex-1 border border-gray-200 text-gray-500 hover:bg-gray-50 font-semibold py-2.5 rounded-xl text-sm transition">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-xl text-sm transition">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
    const storeUrl = "{{ route('admin.hero.store') }}";

    function openModal(slide = null) {
        const overlay     = document.getElementById('modal-overlay');
        const form        = document.getElementById('modal-form');
        const title       = document.getElementById('modal-title');
        const method      = document.getElementById('form-method');
        const preview     = document.getElementById('img-preview');
        const previewWrap = document.getElementById('img-preview-wrap');
        const pageSelector = document.getElementById('page-selector');

        form.reset();
        previewWrap.classList.add('hidden');

        if (slide) {
            title.textContent = 'Ganti Foto';
            form.action       = `/admin/hero-slides/${slide.id}`;
            method.value      = 'PUT';
            document.getElementById('input-aktif').checked = !!slide.aktif;
            pageSelector.classList.add('hidden'); // edit tidak perlu ganti page

            if (slide.gambar) {
                preview.src = `/storage/${slide.gambar}`;
                previewWrap.classList.remove('hidden');
            }
        } else {
            title.textContent = 'Tambah Foto';
            form.action       = storeUrl;
            method.value      = 'POST';
            document.getElementById('input-aktif').checked = true;
            pageSelector.classList.remove('hidden');
        }

        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
    }

    function closeModal() {
        const overlay = document.getElementById('modal-overlay');
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
    }

    function closeModalOnOverlay(e) {
        if (e.target === document.getElementById('modal-overlay')) closeModal();
    }

    document.getElementById('input-gambar').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => {
            document.getElementById('img-preview').src = e.target.result;
            document.getElementById('img-preview-wrap').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush

@endsection