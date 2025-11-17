@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Tambah Data Alumni PGMI</h1>

    <form method="POST" action="{{ route('alumni.s1.pgmi.store') }}" enctype="multipart/form-data"
        class="bg-white rounded-xl shadow-md p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-semibold mb-1">Nama</label>
            <input type="text" name="nama" required
                class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">NIM</label>
            <input type="text" name="nim"
                class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
        </div>

        <input type="hidden" name="prodi" value="PGMI">

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Angkatan</label>
                <input type="number" name="angkatan" min="2000" max="{{ date('Y') }}"
                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Lulusan</label>
                <input type="number" name="lulusan" min="2000" max="{{ date('Y') + 5 }}"
                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Pekerjaan</label>
            <input type="text" name="pekerjaan"
                class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Perusahaan</label>
            <input type="text" name="perusahaan"
                class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email"
                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">No HP</label>
                <input type="text" name="no_hp"
                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Alamat</label>
            <textarea name="alamat" rows="3"
                class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"></textarea>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Foto</label>
                <input type="file" name="foto" accept=".jpg,.jpeg,.png"
                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Ijazah</label>
                <input type="file" name="ijazah" accept=".pdf,.jpg,.jpeg,.png"
                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Transkrip Nilai</label>
                <input type="file" name="transkrip_nilai" accept=".pdf,.jpg,.jpeg,.png"
                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('alumni.s1.pgmi') }}" class="text-gray-500 hover:underline">← Kembali</a>
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-full shadow transition">
                Simpan
            </button>
        </div>
    </form>
</section>
@endsection
