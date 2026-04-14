@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Tambah Data Alumni</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif 

    <form method="POST" action="{{ route('alumni.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-semibold mb-1">Nama</label>
            <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">NIM</label>
            <input type="text" name="nim" value="{{ old('nim') }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Program Studi</label>
            @if(isset($selectedProdi) && $selectedProdi)
                <input type="hidden" name="prodi" value="{{ $selectedProdi }}">
                <p class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-2 text-gray-700">{{ $selectedProdi }}</p>
            @else
                <select name="prodi" id="prodi" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
                    <option value="">-- Pilih Prodi --</option>
                    <optgroup label="S1 - Fakultas Tarbiyah">
                        <option value="PGMI" {{ ($selectedProdi ?? old('prodi'))=='PGMI' ? 'selected' : '' }}>PGMI - Pendidikan Guru Madrasah Ibtidaiyah</option>
                        <option value="PAI" {{ ($selectedProdi ?? old('prodi'))=='PAI' ? 'selected' : '' }}>PAI - Pendidikan Agama Islam</option>
                        <option value="PIAUD" {{ ($selectedProdi ?? old('prodi'))=='PIAUD' ? 'selected' : '' }}>PIAUD - Pendidikan Islam Anak Usia Dini</option>
                        <option value="MPI" {{ ($selectedProdi ?? old('prodi'))=='MPI' ? 'selected' : '' }}>MPI - Manajemen Pendidikan Islam</option>
                        <option value="BKPI" {{ ($selectedProdi ?? old('prodi'))=='BKPI' ? 'selected' : '' }}>BKPI - Bimbingan dan Konseling Pendidikan Islam</option>
                    </optgroup>
                    <optgroup label="S1 - Fakultas Ekonomi & Bisnis Islam">
                        <option value="EKSYAR" {{ ($selectedProdi ?? old('prodi'))=='EKSYAR' ? 'selected' : '' }}>EKSYAR - Ekonomi Syari'ah</option>
                    </optgroup>
                    <optgroup label="S1 - Fakultas Syariah & Hukum">
                        <option value="AS" {{ ($selectedProdi ?? old('prodi'))=='AS' ? 'selected' : '' }}>AS - Hukum Keluarga Islam (Ahwal Syakhshiyyah)</option>
                        <option value="HTN" {{ ($selectedProdi ?? old('prodi'))=='HTN' ? 'selected' : '' }}>HTN - Hukum Tata Negara</option>
                    </optgroup>
                    <optgroup label="S2">
                        <option value="PAI (S2)" {{ ($selectedProdi ?? old('prodi'))=='PAI (S2)' ? 'selected' : '' }}>PAI - Pendidikan Agama Islam (S2)</option>
                    </optgroup>
                </select>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Angkatan</label>
                <input type="number" name="angkatan" value="{{ old('angkatan') }}" min="1950" max="{{ date('Y') }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Tahun Lulus</label>
                <input type="number" name="lulusan" value="{{ old('lulusan') }}" min="1950" max="{{ date('Y')+5 }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Pekerjaan</label>
            <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Perusahaan</label>
            <input type="text" name="perusahaan" value="{{ old('perusahaan') }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Alamat</label>
            <textarea name="alamat" rows="3" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">{{ old('alamat') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Foto (opsional)</label>
            <input type="file" name="foto" accept="image/*" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Upload Ijazah (PDF/JPG)</label>
                <input type="file" name="ijazah" accept=".pdf,.jpg,.jpeg,.png" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Upload Transkrip (PDF/JPG)</label>
                <input type="file" name="transkrip" accept=".pdf,.jpg,.jpeg,.png" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('alumni.data') }}" class="text-gray-500 hover:underline">← Kembali</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-full shadow transition">
                Simpan
            </button>
        </div>
    </form>
</section>
@endsection