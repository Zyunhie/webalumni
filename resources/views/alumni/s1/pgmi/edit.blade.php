@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Data Alumni</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('alumni.s1.pgmi.update', $alumni->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama -->
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-600">*</span></label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $alumni->nama) }}" required
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- NIM -->
            <div class="mb-4">
                <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                <input type="text" name="nim" id="nim" value="{{ old('nim', $alumni->nim) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Prodi (bisa diisi atau readonly jika hanya untuk PGMI) -->
            <div class="mb-4">
                <label for="prodi" class="block text-sm font-medium text-gray-700">Program Studi <span class="text-red-600">*</span></label>
                <input type="text" name="prodi" id="prodi" value="{{ old('prodi', $alumni->prodi) }}" required
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Angkatan -->
            <div class="mb-4">
                <label for="angkatan" class="block text-sm font-medium text-gray-700">Angkatan</label>
                <input type="number" name="angkatan" id="angkatan" value="{{ old('angkatan', $alumni->angkatan) }}"
                       min="1950" max="{{ date('Y') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Tahun Lulus -->
            <div class="mb-4">
                <label for="lulusan" class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                <input type="number" name="lulusan" id="lulusan" value="{{ old('lulusan', $alumni->lulusan) }}"
                       min="1950" max="{{ date('Y')+5 }}"
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Pekerjaan -->
            <div class="mb-4">
                <label for="pekerjaan" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan', $alumni->pekerjaan) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Perusahaan/Instansi -->
            <div class="mb-4">
                <label for="perusahaan" class="block text-sm font-medium text-gray-700">Perusahaan/Instansi</label>
                <input type="text" name="perusahaan" id="perusahaan" value="{{ old('perusahaan', $alumni->perusahaan) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $alumni->email) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- No HP -->
            <div class="mb-4">
                <label for="no_hp" class="block text-sm font-medium text-gray-700">No. HP</label>
                <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $alumni->no_hp) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Foto -->
            <div class="mb-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto Profil</label>
                @if($alumni->foto)
                    <div class="mb-2">
                        <img src="{{ $alumni->foto_url }}" alt="Foto" class="w-20 h-20 object-cover rounded">
                    </div>
                @endif
                <input type="file" name="foto" id="foto" accept="image/*"
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-green-500 focus:border-green-500">
                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah foto.</p>
            </div>

            <!-- Alamat (textarea) -->
            <div class="mb-4 md:col-span-2">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3"
                          class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-green-500 focus:border-green-500">{{ old('alamat', $alumni->alamat) }}</textarea>
            </div>

            <!-- Ijazah -->
            <div class="mb-4">
                <label for="ijazah" class="block text-sm font-medium text-gray-700">File Ijazah</label>
                @if($alumni->ijazah)
                    <div class="mb-2">
                        <a href="{{ asset('storage/'.$alumni->ijazah) }}" target="_blank" class="text-blue-600 underline">Lihat file saat ini</a>
                    </div>
                @endif
                <input type="file" name="ijazah" id="ijazah" accept=".pdf,.jpg,.jpeg,.png"
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-green-500 focus:border-green-500">
                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah. Maks 2MB.</p>
            </div>

            <!-- Transkrip -->
            <div class="mb-4">
                <label for="transkrip" class="block text-sm font-medium text-gray-700">File Transkrip</label>
                @if($alumni->transkrip)
                    <div class="mb-2">
                        <a href="{{ asset('storage/'.$alumni->transkrip) }}" target="_blank" class="text-blue-600 underline">Lihat file saat ini</a>
                    </div>
                @endif
                <input type="file" name="transkrip" id="transkrip" accept=".pdf,.jpg,.jpeg,.png"
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-green-500 focus:border-green-500">
                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah. Maks 2MB.</p>
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-8">
            <a href="{{ route('alumni.s1.pgmi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">Batal</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection