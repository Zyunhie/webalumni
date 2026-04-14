@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Gambar Lowongan --}}
            <div class="lg:col-span-1">
                @if($lowongan->gambar)
                    <img src="{{ asset('storage/' . $lowongan->gambar) }}" alt="{{ $lowongan->judul }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                        No Image Available
                    </div>
                @endif
            </div>

            {{-- Detail Lowongan --}}
            <div class="lg:col-span-2 space-y-8">
                <h1 class="text-3xl font-extrabold text-green-700">{{ $lowongan->judul }}</h1>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4 text-green-700">Detail Lowongan</h2>
                    <div class="space-y-2 text-gray-700">
                        <p><strong>Perusahaan:</strong> {{ $lowongan->perusahaan }}</p>
                        <p><strong>Lokasi:</strong> {{ $lowongan->lokasi ?? 'Indonesia' }}</p>
                        <p><strong>Diposting:</strong> {{ $lowongan->created_at->format('d M Y') }}</p>
                        @if($lowongan->target_prodi)
                            <p><strong>Program Studi yang Ditargetkan:</strong> {{ implode(', ', $lowongan->target_prodi) }}</p>
                        @endif
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4 text-green-700">Deskripsi Pekerjaan</h2>
                    <div class="text-gray-700 leading-relaxed prose max-w-none">
                        {!! nl2br(e($lowongan->deskripsi)) !!}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4 text-green-700">Kualifikasi</h2>
                    <div class="text-gray-700 leading-relaxed">
                        {!! nl2br(e($lowongan->kualifikasi)) !!}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4 text-green-700">Cara Melamar</h2>
                    <div class="text-gray-700">
                        @if($lowongan->external_link)
                            <p>Lamaran dilakukan melalui link eksternal:</p>
                            <a href="{{ $lowongan->external_link }}" target="_blank" class="text-green-600 underline">Klik di sini untuk melamar</a>
                        @else
                            {!! nl2br(e($lowongan->cara_melamar)) !!}
                        @endif
                    </div>
                </div>

                {{-- Tombol Lamar / Status --}}
                <div class="mt-6 flex items-center space-x-4">
                    <a href="{{ route('lowongan.index') }}" class="inline-block bg-gray-500 text-white px-6 py-2 rounded-full hover:bg-gray-400 transition">
                        ← Kembali ke Lowongan
                    </a>

                    @auth
                        @if($canApply)
                            @if($alreadyApplied)
                                <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full">Anda sudah melamar lowongan ini.</span>
                            @else
                                <button onclick="document.getElementById('lamarForm').classList.toggle('hidden')" 
                                        class="bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 transition">
                                    Lamar Sekarang
                                </button>
                            @endif
                        @else
                            @if(auth()->user()->role === 'alumni' && auth()->user()->alumni && auth()->user()->alumni->status !== 'approved')
                                <span class="text-red-600">Akun alumni Anda belum disetujui admin.</span>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-green-600 underline">Login sebagai Alumni untuk melamar</a>
                    @endauth
                </div>

                {{-- Form Lamaran (hidden by default) --}}
                @auth
                    @if($canApply && !$alreadyApplied)
                        <div id="lamarForm" class="hidden mt-6 bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-bold mb-4">Form Lamaran</h3>
                            <form action="{{ route('lowongan.lamar', $lowongan) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label class="block font-medium mb-1">Cover Letter (Opsional)</label>
                                    <textarea name="cover_letter" rows="4" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">{{ old('cover_letter') }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="block font-medium mb-1">Upload CV (PDF, max 2MB)</label>
                                    <input type="file" name="cv_file" accept=".pdf" class="w-full border-gray-300 rounded-lg">
                                </div>
                                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700">
                                    Kirim Lamaran
                                </button>
                                <button type="button" onclick="document.getElementById('lamarForm').classList.add('hidden')" class="ml-2 text-gray-600 underline">Batal</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection