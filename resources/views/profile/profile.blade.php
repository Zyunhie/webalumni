@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Profil Alumni Saya</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    @if($alumni->count() == 0)
        <div class="bg-yellow-100 text-yellow-800 p-6 rounded-lg text-center">
            <p>Anda belum mengisi data alumni. Silakan tambah data Anda.</p>
            <a href="{{ route('alumni.create') }}" class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-full">Tambah Data</a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($alumni as $data)
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-xl font-semibold">{{ $data->nama }}</h2>
                            <p class="text-gray-600">{{ $data->prodi }} - {{ $data->angkatan }}</p>
                            <p class="text-sm mt-2">Status: 
                                @if($data->status == 'approved')
                                    <span class="text-green-600 font-semibold">Disetujui</span>
                                @elseif($data->status == 'pending')
                                    <span class="text-yellow-600 font-semibold">Menunggu persetujuan</span>
                                @else
                                    <span class="text-red-600 font-semibold">Ditolak</span>
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('alumni.edit', $data->id) }}" class="bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded-lg text-sm">Edit</a>
                    </div>
                    <div class="mt-4 grid md:grid-cols-2 gap-4 text-sm">
                        <div><span class="font-semibold">NIM:</span> {{ $data->nim ?? '-' }}</div>
                        <div><span class="font-semibold">Lulusan:</span> {{ $data->lulusan ?? '-' }}</div>
                        <div><span class="font-semibold">Pekerjaan:</span> {{ $data->pekerjaan ?? '-' }}</div>
                        <div><span class="font-semibold">Perusahaan:</span> {{ $data->perusahaan ?? '-' }}</div>
                        <div><span class="font-semibold">Email:</span> {{ $data->email ?? '-' }}</div>
                        <div><span class="font-semibold">No HP:</span> {{ $data->no_hp ?? '-' }}</div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('alumni.show', $data->id) }}" class="text-green-600 hover:underline">Lihat Detail</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection