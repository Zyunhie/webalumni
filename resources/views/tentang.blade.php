@extends('layouts.app')

@section('content')

    <!-- ================= HERO SECTION ================= -->
    <section class="relative h-[400px] bg-cover bg-center overflow-hidden"
        style="background-image: url('{{ $heroTentang ? Storage::url($heroTentang->gambar) : asset('images/Branda.jpg') }}');">

        @if(auth()->check() && trim(auth()->user()->role) === 'admin')
            <a href="{{ route('admin.hero.index') }}"
                class="absolute bottom-4 right-4 z-10 bg-white bg-opacity-90 hover:bg-opacity-100 text-green-700 font-semibold text-xs px-4 py-2 rounded-full shadow-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Kelola Slider
            </a>
        @endif
    </section>

    <!-- ================= DESKRIPSI ================= -->
    <section class="max-w-5xl mx-auto px-6 py-12 text-center">
        <h2 class="text-2xl font-bold text-green-700 mb-4">
            Website Alumni Institut Agama Islam Tasikmalaya
        </h2>
        <p class="text-gray-700 leading-relaxed">
            Website ini dibuat sebagai wadah komunikasi dan informasi antara para alumni
            Institut Agama Islam Tasikmalaya. Melalui platform ini, alumni dapat berbagi
            pengalaman, mengikuti agenda kampus, serta membuka peluang kerja sama.
            Kami berharap website ini menjadi penghubung yang mempererat tali silaturahmi
            antar alumni IAIT.
        </p>
    </section>

    <!-- ================= VISI & MISI ================= -->
    <section class="bg-gray-100 py-12" x-data="{
            openModal: false,
            editField: '',
            visi: '',
            misi: '',
            draftVisi: '',
            draftMisi: ''
        }" x-init="
            visi = @js($about->visi);
            misi = @js($about->misi);
        ">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-8">

            <!-- VISI -->
            <div class="bg-white rounded-2xl shadow p-8 relative">
                <h3 class="text-xl font-bold text-green-700 mb-4">Visi</h3>
                <p class="text-gray-700 whitespace-pre-line" x-text="visi"></p>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <button class="absolute top-4 right-4 px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700"
                            @click="editField = 'visi'; draftVisi = visi; openModal = true;">
                            Edit
                        </button>
                    @endif
                @endauth
            </div>

            <!-- MISI -->
            <div class="bg-white rounded-2xl shadow p-8 relative">
                <h3 class="text-xl font-bold text-green-700 mb-4">Misi</h3>
                <p class="text-gray-700 whitespace-pre-line" x-text="misi"></p>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <button class="absolute top-4 right-4 px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700"
                            @click="editField = 'misi'; draftMisi = misi; openModal = true;">
                            Edit
                        </button>
                    @endif
                @endauth
            </div>

        </div>

        <!-- MODAL EDIT VISI MISI -->
        <div x-cloak x-show="openModal" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl w-11/12 md:w-1/2 p-6">
                <h3 class="text-xl font-bold text-green-700 mb-4" x-text="editField === 'visi' ? 'Edit Visi' : 'Edit Misi'">
                </h3>
                <textarea x-show="editField === 'visi'" x-model="draftVisi" rows="6"
                    class="w-full border rounded p-3 mb-4 focus:outline-none focus:ring focus:ring-green-200"></textarea>
                <textarea x-show="editField === 'misi'" x-model="draftMisi" rows="6"
                    class="w-full border rounded p-3 mb-4 focus:outline-none focus:ring focus:ring-green-200"></textarea>
                <div class="flex justify-end gap-2">
                    <button class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400"
                        @click="openModal = false">Batal</button>
                    <button type="button" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700" @click="
                            fetch('{{ route('admin.tentang.update.text') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                                },
                                body: JSON.stringify({ field: editField, value: editField === 'visi' ? draftVisi : draftMisi })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    if (editField === 'visi') visi = draftVisi;
                                    if (editField === 'misi') misi = draftMisi;
                                    openModal = false;
                                }
                            })
                            .catch(() => alert('Gagal menyimpan data'));
                        ">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= STRUKTUR KAMPUS ================= -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-2xl font-bold text-green-700 mb-8">Struktur Kampus IAIT</h2>
            <div class="bg-gray-50 p-6 rounded-xl shadow mb-6">
                <img src="{{ $about->struktur_image ? asset('storage/' . $about->struktur_image) . '?v=' . time() : asset('images/S.png') }}"
                    alt="Struktur Kampus IAIT" class="w-full rounded-lg object-contain mx-auto">
            </div>
            @auth
                @if(auth()->check() && trim(auth()->user()->role) === 'admin')
                    <form action="{{ route('admin.tentang.update.image') }}" method="POST" enctype="multipart/form-data"
                        class="max-w-md mx-auto bg-gray-100 p-6 rounded-xl shadow">
                        @csrf
                        <label class="block text-left font-semibold mb-2">Ganti Gambar Struktur Kampus</label>
                        <input type="file" name="struktur_image" accept="image/*" required class="w-full mb-4">
                        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                            Upload Gambar
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    </section>

@endsection