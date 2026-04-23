@extends('layouts.app')

@section('title', 'Tambah Testimoni')

@section('content')
<section class="max-w-2xl mx-auto px-6 py-12">
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Tambah Testimoni</h1>
        <p class="text-xl text-gray-600">Bagikan pengalaman suksesmu sebagai alumni kami</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-8">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-8">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-8">
            {{ session('error') }}
        </div>
    @endif

    <!-- Stats Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-8 rounded-2xl shadow-xl text-center">
            <div class="text-3xl font-bold mb-2">{{ $myTestimonials->where('status', 'approved')->count() }}</div>
            <div class="text-lg">Approved</div>
        </div>
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-8 rounded-2xl shadow-xl text-center">
            <div class="text-3xl font-bold mb-2">{{ $myTestimonials->where('status', 'pending')->count() }}</div>
            <div class="text-lg">Menunggu Review</div>
        </div>
        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-8 rounded-2xl shadow-xl text-center">
            <div class="text-3xl font-bold mb-2">{{ $myTestimonials->where('status', 'rejected')->count() }}</div>
            <div class="text-lg">Ditolak</div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 mb-12 p-6 bg-gradient-to-r from-green-50 to-blue-50 rounded-2xl">
        {{-- FIX: route name dari testimonials.create → testimoni.create --}}
        <a href="{{ route('testimoni.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 flex-1 text-center">
            + Tambah Testimoni Baru
        </a>
        {{-- FIX: route name dari testimonials.index → testimoni.index --}}
        <a href="{{ route('testimoni.index') }}" class="bg-white border-2 border-gray-200 hover:border-green-500 text-gray-800 font-semibold px-8 py-4 rounded-xl hover:bg-green-50 transition flex-1 text-center">
            Lihat Galeri Publik
        </a>
    </div>

    <!-- Testimoni Table -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        @if($myTestimonials->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Foto</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Detail</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($myTestimonials as $t)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($t->foto)
                                    <img src="{{ Storage::url($t->foto) }}" alt="{{ $t->nama }}" class="w-16 h-16 rounded-xl object-cover">
                                @else
                                    <div class="w-16 h-16 bg-gradient-to-br from-gray-200 to-gray-300 rounded-xl flex items-center justify-center">
                                        <span class="text-gray-500 font-semibold">👤</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900">{{ $t->nama }}</div>
                                <div class="text-sm text-gray-500">{{ $t->jurusan }} • {{ $t->tahun_lulus }}</div>
                                <div class="text-sm text-gray-600 mt-1">{{ Str::limit($t->isi_testimoni, 80) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($t->status)
                                    @case('approved')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Disetujui</span>
                                        @break
                                    @case('pending')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Menunggu Review</span>
                                        @break
                                    @case('rejected')
                                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Ditolak</span>
                                        @if($t->alasan_penolakan)
                                            <div class="text-xs text-red-600 mt-1 italic bg-red-50 px-2 py-1 rounded">
                                                "{{ Str::limit($t->alasan_penolakan, 50) }}"
                                            </div>
                                        @endif
                                        @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                @if($t->status !== 'approved')
                                    {{-- FIX: route name dari testimonials.edit → testimoni.edit --}}
                                    <a href="{{ route('testimoni.edit', $t) }}" class="text-green-600 hover:text-green-900 font-semibold">
                                        Edit
                                    </a>
                                @endif
                                @if($t->status !== 'approved')
                                    {{-- FIX: route name dari testimonials.destroy → testimoni.destroy --}}
                                    <form action="{{ route('testimoni.destroy', $t) }}" method="POST" class="inline" onsubmit="return confirm('Hapus testimoni ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
    {{-- FIX: form tag lengkap + enctype wajib untuk file upload --}}
    <form method="POST" action="{{ route('testimoni.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="space-y-6">
            <!-- Nama Lengkap -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
                       class="w-full px-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition text-lg"
                       placeholder="Masukkan nama lengkap">
            </div>

            <!-- Jurusan -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jurusan/Program Studi <span class="text-red-500">*</span></label>
                <input type="text" name="jurusan" value="{{ old('jurusan') }}" required
                       class="w-full px-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition text-lg"
                       placeholder="Contoh: PGMI / PAI / MPI">
            </div>

            <!-- Tahun Lulus -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Lulus <span class="text-red-500">*</span></label>
                <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus') }}" min="1900" max="2030" required
                       class="w-full px-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition text-lg"
                       placeholder="Contoh: 2020">
            </div>

            <!-- Pekerjaan -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pekerjaan Saat Ini</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}"
                       class="w-full px-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition text-lg"
                       placeholder="Contoh: Guru / Programmer / Manager">
            </div>

            <!-- Perusahaan -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tempat Kerja/Perusahaan</label>
                <input type="text" name="perusahaan" value="{{ old('perusahaan') }}"
                       class="w-full px-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition text-lg"
                       placeholder="Contoh: PT ABC / SDN 1 Tasik / Freelance">
            </div>

            <!-- Foto -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Profil (Opsional)</label>

                {{-- FIX: Preview area - hidden by default, muncul setelah pilih file --}}
                <div id="foto-preview-wrapper" class="hidden mb-4 p-4 bg-gray-50 rounded-xl border-2 border-dashed border-green-300 text-center">
                    <img id="foto-preview" src="" alt="Preview foto" class="w-32 h-32 object-cover rounded-2xl mx-auto">
                    <p class="text-sm text-green-600 mt-2 font-semibold" id="foto-filename"></p>
                    <button type="button" id="foto-remove" class="text-xs text-red-500 hover:text-red-700 mt-1">× Ganti foto</button>
                </div>

                <div id="foto-dropzone" class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:border-green-400 transition cursor-pointer group">
                    <input type="file" name="foto" accept="image/*" class="hidden" id="foto-upload">
                    <label for="foto-upload" class="cursor-pointer">
                        <div class="group-hover:text-green-600 transition">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p class="text-lg font-semibold text-gray-700 group-hover:text-green-600">Klik untuk upload foto</p>
                            <p class="text-sm text-gray-500 mt-1">JPG, PNG max 2MB</p>
                        </div>
                    </label>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada testimoni</h3>
                <p class="text-gray-600 mb-8">Mulai bagikan pengalaman Anda dengan menambah testimoni baru</p>
                {{-- FIX: route name dari testimonials.create → testimoni.create --}}
                <a href="{{ route('testimoni.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold px-12 py-4 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                    + Tambah Testimoni Pertama
                </a>
            </div>

            <!-- Isi Testimoni -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Testimoni Anda <span class="text-red-500">*</span></label>
                <textarea name="isi_testimoni" rows="8" required
                          class="w-full px-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition text-lg resize-vertical"
                          placeholder="Ceritakan pengalaman belajar Anda, manfaat kuliah di sini, dan kesuksesan setelah lulus...">{{ old('isi_testimoni') }}</textarea>
                <p class="text-xs text-gray-500 mt-2">Minimal 50 karakter. Testimoni Anda akan di-review oleh admin sebelum dipublikasikan.</p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 mt-12 pt-8 border-t border-gray-200">
            <a href="{{ route('testimoni.index') }}" class="flex-1 sm:flex-none bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold px-8 py-4 rounded-xl text-center transition">
                ← Kembali ke Galeri
            </a>
            <button type="submit" class="flex-1 sm:flex-none bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                Kirim Testimoni untuk Review
            </button>
        </div>
    </form>

    <div class="mt-16 text-center text-gray-500">
        <p class="text-lg">Testimoni Anda akan muncul di galeri setelah disetujui admin.</p>
        <p class="mt-2 text-sm">Estimasi review: 24-48 jam</p>
    </div>
</section>

<script>
    const fotoUpload      = document.getElementById('foto-upload');
    const fotoPreview     = document.getElementById('foto-preview');
    const fotoWrapper     = document.getElementById('foto-preview-wrapper');
    const fotoDropzone    = document.getElementById('foto-dropzone');
    const fotoFilename    = document.getElementById('foto-filename');
    const fotoRemove      = document.getElementById('foto-remove');

    fotoUpload.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        // Validasi ukuran di sisi client (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            fotoPreview.src     = e.target.result;
            fotoFilename.textContent = file.name;
            fotoWrapper.classList.remove('hidden');
            fotoDropzone.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });

    // Tombol ganti foto — reset input dan tampilkan dropzone lagi
    fotoRemove.addEventListener('click', function () {
        fotoUpload.value    = '';
        fotoPreview.src     = '';
        fotoFilename.textContent = '';
        fotoWrapper.classList.add('hidden');
        fotoDropzone.classList.remove('hidden');
    });
</script>
@endsection