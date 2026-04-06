@extends('layouts.app')

@section('content')
@php
    // Mapping kode prodi ke route name
    $prodiRoutes = [
        'PGMI' => 'alumni.s1.pgmi.',
        'PAI' => 'alumni.s1.pai.',
        'PIAUD' => 'alumni.s1.piaud.',
        'MPI' => 'alumni.s1.mpi.',
        'BKPI' => 'alumni.s1.bkpi.',
        'EKSYAR' => 'alumni.s1.eksyar.',
        'AS' => 'alumni.s1.as.',
        'HTN' => 'alumni.s1.htn.',
        'PAI (S2)' => 'alumni.s2.pai.',
    ];
    $routePrefix = $prodiRoutes[$alumni->prodi] ?? 'alumni.s1.pgmi.';
@endphp

<section class="max-w-4xl mx-auto px-6 py-10">
    <div class="bg-white rounded-xl shadow-md p-8">
        <div class="flex justify-between items-start mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Alumni</h1>
            @auth
                @if(auth()->user()->role === 'admin' || auth()->id() == $alumni->user_id)
                    <a href="{{ route($routePrefix . 'edit', $alumni->id) }}" class="bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded-lg">Edit</a>
                @endif
            @endauth
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                @if($alumni->foto)
                    <img src="{{ $alumni->foto_url }}" alt="foto" class="w-full rounded-lg shadow">
                @else
                    <div class="bg-gray-200 h-48 flex items-center justify-center rounded-lg text-gray-500">Tidak ada foto</div>
                @endif
            </div>
            <div class="md:col-span-2 space-y-3">
                <p><span class="font-semibold">Nama:</span> {{ $alumni->nama }}</p>
                <p><span class="font-semibold">NIM:</span> {{ $alumni->nim ?? '-' }}</p>
                <p><span class="font-semibold">Program Studi:</span> {{ $alumni->prodi }}</p>
                <p><span class="font-semibold">Angkatan:</span> {{ $alumni->angkatan ?? '-' }}</p>
                <p><span class="font-semibold">Tahun Lulus:</span> {{ $alumni->lulusan ?? '-' }}</p>
                <p><span class="font-semibold">Pekerjaan:</span> {{ $alumni->pekerjaan ?? '-' }}</p>
                <p><span class="font-semibold">Perusahaan:</span> {{ $alumni->perusahaan ?? '-' }}</p>
                <p><span class="font-semibold">Email:</span> {{ $alumni->email ?? '-' }}</p>
                <p><span class="font-semibold">No HP:</span> {{ $alumni->no_hp ?? '-' }}</p>
                <p><span class="font-semibold">Alamat:</span> {{ $alumni->alamat ?? '-' }}</p>

                @if($alumni->ijazah)
                    <p><span class="font-semibold">Ijazah:</span> <a href="{{ $alumni->ijazah_url }}" target="_blank" class="text-blue-600 underline">Lihat</a></p>
                @endif
                @if($alumni->transkrip)
                    <p><span class="font-semibold">Transkrip:</span> <a href="{{ $alumni->transkrip_url }}" target="_blank" class="text-blue-600 underline">Lihat</a></p>
                @endif

                @if($alumni->status != 'approved' && (auth()->user()->role === 'admin' || auth()->id() == $alumni->user_id))
                    <div class="bg-yellow-100 text-yellow-800 p-3 rounded mt-4">
                        Status: <strong>{{ ucfirst($alumni->status) }}</strong>. Data ini belum disetujui admin, sehingga tidak tampil di publik.
                    </div>
                @endif
            </div>

        <div class="mt-6">
            <a href="{{ route($routePrefix . 'index') }}" class="text-gray-500 hover:underline">← Kembali ke daftar alumni</a>
        </div>
</section>
@endsection
