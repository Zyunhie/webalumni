@extends('layouts.app')

@section('title', 'Kelola Testimoni')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_340px] gap-8 items-start">
        <div>
            <a href="{{ route('testimoni.index') }}" class="text-sm text-gray-500 hover:text-green-700 font-semibold">Kembali ke galeri</a>
            <div class="mt-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Kelola Testimoni</h1>
                    <p class="text-gray-500 mt-2">
                        @if(auth()->user()->role === 'admin')
                            Admin dapat memperbaiki konten tanpa mengubah status review.
                        @else
                            Revisi dari alumni akan masuk antrean review ulang.
                        @endif
                    </p>
                </div>
                <span class="inline-flex w-fit px-3 py-1.5 rounded-full border text-xs font-semibold {{ $testimoni->status_badge_class }}">
                    {{ $testimoni->status_label }}
                </span>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mt-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl mt-6 text-sm">
                    {{ session('info') }}
                </div>
            @endif

            @if($testimoni->status === 'rejected' && $testimoni->alasan_penolakan)
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mt-6 text-sm">
                    <div class="font-bold mb-1">Alasan penolakan admin</div>
                    <div>{{ $testimoni->alasan_penolakan }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mt-6 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <div>- {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('testimoni.update', $testimoni) }}" enctype="multipart/form-data"
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-6 mt-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
                        <input type="text" value="{{ $testimoni->nama }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm bg-gray-50 text-gray-500" readonly disabled>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jurusan / Prodi</label>
                        <input type="text" value="{{ $testimoni->jurusan ?? '-' }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm bg-gray-50 text-gray-500" readonly disabled>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun Lulus</label>
                        <input type="text" value="{{ $testimoni->tahun_lulus ?? '-' }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm bg-gray-50 text-gray-500" readonly disabled>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Pekerjaan Saat Ini</label>
                        <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $testimoni->pekerjaan) }}"
                            placeholder="Contoh: Guru, Founder, Software Engineer"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Instansi / Perusahaan</label>
                        <input type="text" name="perusahaan" value="{{ old('perusahaan', $testimoni->perusahaan) }}"
                            placeholder="Contoh: MA Al-Hikmah, PT Nusantara"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Isi Testimoni <span class="text-red-500">*</span></label>
                    <textarea name="isi_testimoni" rows="8" required maxlength="2000"
                        class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none resize-y">{{ old('isi_testimoni', $testimoni->isi_testimoni) }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Maksimal 2000 karakter.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Profil</label>
                    @if($testimoni->foto)
                        <div class="mb-3 flex items-center gap-3">
                            <img src="{{ Storage::url($testimoni->foto) }}" alt="Foto testimoni"
                                class="w-16 h-16 object-cover rounded-full border border-gray-200">
                            <p class="text-xs text-gray-400">Upload foto baru untuk mengganti foto saat ini.</p>
                        </div>
                    @endif
                    <input type="file" name="foto" accept="image/*"
                        class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 file:text-green-700 file:font-semibold hover:file:bg-green-100 cursor-pointer border border-gray-200 rounded-lg p-2">
                    <p class="text-xs text-gray-400 mt-1">Maksimal 2MB, format JPG/PNG.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <a href="{{ route('testimoni.index') }}"
                        class="sm:w-40 text-center border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold py-2.5 rounded-lg text-sm transition">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg text-sm transition">
                        {{ auth()->user()->role === 'admin' ? 'Simpan Perubahan' : 'Kirim Revisi' }}
                    </button>
                </div>
            </form>
        </div>

        <aside class="space-y-4 lg:sticky lg:top-24">
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                <h2 class="font-bold text-gray-900">Status Review</h2>
                <div class="mt-4 space-y-3 text-sm text-gray-600">
                    <div class="flex justify-between gap-4">
                        <span>Status</span>
                        <span class="font-semibold text-gray-900">{{ $testimoni->status_label }}</span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span>Dibuat</span>
                        <span class="font-semibold text-gray-900">{{ $testimoni->created_at->format('d M Y') }}</span>
                    </div>
                    @if($testimoni->approved_at)
                        <div class="flex justify-between gap-4">
                            <span>Disetujui</span>
                            <span class="font-semibold text-gray-900">{{ $testimoni->approved_at->format('d M Y') }}</span>
                        </div>
                    @endif
                    @if($testimoni->approver)
                        <div class="flex justify-between gap-4">
                            <span>Reviewer</span>
                            <span class="font-semibold text-gray-900">{{ $testimoni->approver->name }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <form action="{{ route('testimoni.destroy', $testimoni) }}" method="POST"
                onsubmit="return confirm('Hapus testimoni ini secara permanen?')"
                class="bg-white border border-red-100 rounded-xl p-6 shadow-sm">
                @csrf
                @method('DELETE')
                <h2 class="font-bold text-red-700">Hapus Testimoni</h2>
                <p class="text-sm text-gray-500 mt-2">Data testimoni dan foto yang terkait akan dihapus permanen.</p>
                <button type="submit" class="mt-4 w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg text-sm transition">
                    Hapus
                </button>
            </form>
        </aside>
    </div>
</div>
@endsection
