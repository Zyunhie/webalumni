@extends('layouts.app')

@section('title', 'Detail Agenda')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-8 text-white">
            <h1 class="text-3xl font-bold mb-2">{{ $agenda->judul }}</h1>
            <p class="text-blue-100">{{ $agenda->deskripsi }}</p>
        </div>
        
        <div class="p-8">
            @if($agenda->gambar)
                <img src="{{ asset('storage/' . $agenda->gambar) }}" alt="{{ $agenda->judul }}" class="w-full h-64 object-cover rounded-lg mb-6">
            @endif
            
            <div class="space-y-4 text-gray-700">
                <div>
                    <span class="font-semibold">Tanggal Mulai:</span>
                    <span class="ml-2">{{ \Carbon\Carbon::parse($agenda->tanggal_mulai)->translatedFormat('d F Y H:i') }}</span>
                </div>
                
                @if($agenda->tanggal_selesai)
                <div>
                    <span class="font-semibold">Tanggal Selesai:</span>
                    <span class="ml-2">{{ \Carbon\Carbon::parse($agenda->tanggal_selesai)->translatedFormat('d F Y H:i') }}</span>
                </div>
                @endif
                
                @if($agenda->lokasi)
                <div>
                    <span class="font-semibold">Lokasi:</span>
                    <span class="ml-2">{{ $agenda->lokasi }}</span>
                </div>
                @endif
            </div>
            
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('alumni.agenda') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
                    ← Kembali ke Daftar
                </a>
                
                @auth
                <a href="{{ route('alumni.agenda.edit', $agenda) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg font-medium transition">
                    Edit
                </a>
                <form method="POST" action="{{ route('alumni.agenda.destroy', $agenda) }}" class="inline" onsubmit="return confirm('Yakin hapus?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition">
                        Hapus
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection

