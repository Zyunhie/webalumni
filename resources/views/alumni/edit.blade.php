
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
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Edit Data Alumni</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route($routePrefix . 'update', $alumni->id) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md p-6 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold mb-1">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama', $alumni->nama) }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">NIM</label>
            <input type="text" name="nim" value="{{ old('nim', $alumni->nim) }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Program Studi</label>
            <input type="hidden" name="prodi" value="{{ old('prodi', $alumni->prodi) }}">
            <p class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-2 text-gray-700">{{ old('prodi', $alumni->prodi) }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Angkatan</label>
                <input type="number" name="angkatan" value="{{ old('angkatan', $alumni->angkatan) }}" min="1950" max="{{ date('Y') }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Tahun Lulus</label>
                <input type="number" name="lulusan" value="{{ old('lulusan', $alumni->lulusan) }}" min="1950" max="{{ date('Y')+5 }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Pekerjaan</label>
            <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $alumni->pekerjaan) }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Perusahaan</label>
            <input type="text" name="perusahaan" value="{{ old('perusahaan', $alumni->perusahaan) }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $alumni->email) }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $alumni->no_hp) }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Alamat</label>
            <textarea name="alamat" rows="3" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">{{ old('alamat', $alumni->alamat) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Foto</label>
            @if($alumni->foto)
                <div class="mb-2">
                    <img src="{{ $alumni->foto_url }}" alt="foto" class="h-20 w-20 object-cover rounded">
                </div>
            @endif
            <input type="file" name="foto" accept="image/*" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            <p class="text-xs text-gray-500">Kosongkan jika tidak ingin mengganti</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Ijazah</label>
                @if($alumni->ijazah)
                    <div class="mb-2">
                        <a href="{{ $alumni->ijazah_url }}" target="_blank" class="text-blue-600 underline">Lihat file</a>
                    </div>
                @endif
                <input type="file" name="ijazah" accept=".pdf,.jpg,.jpeg,.png" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Transkrip</label>
                @if($alumni->transkrip)
                    <div class="mb-2">
                        <a href="{{ $alumni->transkrip_url }}" target="_blank" class="text-blue-600 underline">Lihat file</a>
                    </div>
                @endif
                <input type="file" name="transkrip" accept=".pdf,.jpg,.jpeg,.png" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route($routePrefix . 'index') }}" class="text-gray-500 hover:underline">← Kembali</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-full shadow transition">
                Update
            </button>
        </div>
    </form>
</section>
@endsection

