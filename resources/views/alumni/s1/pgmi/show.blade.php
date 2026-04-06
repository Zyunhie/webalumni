@extends('layouts.app')

@section('content')
<section class="max-w-3xl mx-auto px-6 py-12">
    <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
        <img src="{{ $alumni->foto_url }}" 
             alt="{{ $alumni->nama }}" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
        <h2 class="text-2xl font-bold text-green-700 mb-1">{{ $alumni->nama }}</h2>
        <p class="text-gray-500 mb-6">{{ $alumni->prodi }} - Angkatan {{ $alumni->angkatan ?? '-' }}</p>

        <div class="text-left space-y-2 text-gray-700">
            <p><strong>NIM:</strong> {{ $alumni->nim ?? '-' }}</p>
            <p><strong>Lulusan:</strong> {{ $alumni->lulusan ?? '-' }}</p>
            <p><strong>Pekerjaan:</strong> {{ $alumni->pekerjaan ?? '-' }}</p>
            <p><strong>Perusahaan:</strong> {{ $alumni->perusahaan ?? '-' }}</p>
            <p><strong>Email:</strong> {{ $alumni->email ?? '-' }}</p>
            <p><strong>No HP:</strong> {{ $alumni->no_hp ?? '-' }}</p>
            <p><strong>Alamat:</strong> {{ $alumni->alamat ?? '-' }}</p>
        </div>

        <div class="mt-6 border-t pt-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Dokumen Akademik</h3>
            @if($alumni->ijazah || $alumni->transkrip_nilai)
                @if($alumni->ijazah)
                <div class="flex justify-between items-center border-b py-2">
                    <span>📄 Ijazah</span>
                    <div>
                        <a href="{{ asset($alumni->ijazah) }}" target="_blank" class="text-blue-600 hover:underline mr-2">Lihat</a>
                        <a href="{{ asset($alumni->ijazah) }}" download class="text-green-600 hover:underline">Download</a>
                    </div>
                </div>
                @endif
                @if($alumni->transkrip_nilai)
                <div class="flex justify-between items-center border-b py-2">
                    <span>📘 Transkrip Nilai</span>
                    <div>
                        <a href="{{ asset($alumni->transkrip_nilai) }}" target="_blank" class="text-blue-600 hover:underline mr-2">Lihat</a>
                        <a href="{{ asset($alumni->transkrip_nilai) }}" download class="text-green-600 hover:underline">Download</a>
                    </div>
                </div>
                @endif
            @else
                <p class="text-gray-500 italic">Belum ada dokumen yang diunggah.</p>
            @endif
        </div>

        <div class="mt-8">
            <a href="{{ route('alumni.s1.pgmi') }}"
               class="bg-gray-500 hover:bg-gray-400 text-white px-6 py-2 rounded-full transition">
               ← Kembali ke Daftar Alumni
            </a>
        </div>
    </div>
</section>
@endsection
