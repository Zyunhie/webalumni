@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Dashboard Lowongan Saya</h1>
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Rekomendasi Lowongan -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Rekomendasi Lowongan</h2>
                        @if(isset($lowongans) && $lowongans->count() > 0)
                            @foreach($lowongans as $lowongan)
                                <div class="border-b pb-4 mb-4 last:border-b-0 last:mb-0">
                                    <h3 class="font-medium text-gray-900">{{ $lowongan->judul }}</h3>
                                    <p class="text-sm text-gray-500">{{ $lowongan->perusahaan }}</p>
                                    <a href="{{ route('lowongan.show', $lowongan) }}" class="text-green-600 hover:text-green-500 text-sm font-medium mt-1 inline-block">Lihat Detail →</a>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500">Belum ada lowongan untuk prodi Anda. Cek <a href="{{ route('lowongan.index') }}" class="text-green-600 hover:underline">lowongan umum</a>.</p>
                        @endif
                    </div>
                </div>

                <!-- Lowongan Populer -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Pekerjaan Populer</h2>
                        @if(isset($populerJobs) && $populerJobs->count() > 0)
                            <ul class="space-y-2">
                                @foreach($populerJobs as $pekerjaan => $count)
                                    <li class="flex justify-between text-sm">
                                        <span>{{ $pekerjaan }}</span>
                                        <span class="font-medium text-green-600">({{ $count }} alumni)</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">Belum ada data pekerjaan alumni.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
