@extends('layouts.app')

@section('content')

    {{-- Hero Section --}}
    <section class="relative h-[400px] bg-cover bg-center"
        style="background-image: url('{{ $heroAgenda ? Storage::url($heroAgenda->gambar) : asset('images/Branda.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-white">
            <h1 class="text-4xl font-bold">Agenda</h1>
            <p class="mt-2 text-sm">
                <a href="{{ route('home') }}" class="hover:underline">Beranda</a> > Agenda
            </p>
        </div>
        @if(auth()->check() && auth()->user()->role === 'admin')
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

    {{-- Header dengan Tombol Admin --}}
    <div class="max-w-4xl mx-auto px-6 py-8">
        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        @auth
            {{-- PERBAIKAN: gunakan pengecekan role === 'admin' --}}
            @if(auth()->user()->role === 'admin')
                <div
                    class="flex flex-col sm:flex-row gap-4 justify-between items-center mb-12 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-3xl shadow-lg border-4 border-blue-100">
                    <div class="text-center sm:text-left">
                        <h2 class="text-2xl font-bold text-gray-800 mb-1">Agenda Alumni IAIT</h2>
                        <p class="text-gray-600">Kelola agenda kegiatan ({{ $agendas->count() }})</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="openDeleteAllModal()"
                            class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-2xl shadow-lg transition-all flex items-center gap-2">
                            <i class="bi bi-trash3-fill"></i> Hapus Semua
                        </button>
                        <button onclick="openCreateModal()"
                            class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-2xl shadow-lg transition-all flex items-center gap-2">
                            <i class="bi bi-plus-circle-fill"></i> Tambah
                        </button>
                    </div>
                </div>
            @endif
        @endauth
    </div>

    {{-- Daftar Agenda --}}
    <section class="max-w-4xl mx-auto px-6 pb-12 space-y-6">
        @forelse($agendas as $agenda)
            <div id="agenda-{{ $agenda->id }}"
                class="agenda-card border-2 border-gray-300 rounded-[24px] overflow-hidden transition-all duration-300 hover:shadow-xl cursor-pointer"
                onclick="toggleAgenda(this)">
                <div class="header p-6 flex items-center justify-between h-28 bg-white relative">
                    <div class="flex items-center gap-3 flex-1">
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <div class="flex gap-1">
                                    <button onclick="event.stopPropagation(); openEditModal({{ $agenda->id }})"
                                        class="w-10 h-10 bg-blue-500 hover:bg-blue-600 text-white rounded-lg flex items-center justify-center transition-all shadow-md hover:shadow-lg"
                                        title="Edit">
                                        <i class="bi bi-pencil-fill text-sm"></i>
                                    </button>
                                    <button onclick="event.stopPropagation(); confirmDelete({{ $agenda->id }})"
                                        class="w-10 h-10 bg-red-500 hover:bg-red-600 text-white rounded-lg flex items-center justify-center transition-all shadow-md hover:shadow-lg"
                                        title="Hapus">
                                        <i class="bi bi-trash-fill text-sm"></i>
                                    </button>
                                </div>
                            @endif
                        @endauth
                        <div class="flex-1">
                            <h3 class="font-bold text-xl text-gray-800 line-clamp-1 mb-1">{{ $agenda->judul }}</h3>
                            <span class="text-sm text-gray-500 flex items-center gap-1">
                                <i class="bi bi-calendar-event"></i>
                                {{ \Carbon\Carbon::parse($agenda->tanggal_mulai)->isoFormat('D MMM YYYY') }}
                                @if($agenda->tanggal_selesai) -
                                {{ \Carbon\Carbon::parse($agenda->tanggal_selesai)->isoFormat('D MMM YYYY') }} @endif
                            </span>
                        </div>
                    </div>
                    <div class="arrow-wrapper p-2">
                        <svg class="arrow-down w-6 h-6 text-gray-500 transition-transform duration-300 cursor-pointer"
                            onclick="event.stopPropagation(); toggleAgenda(this.closest('.agenda-card'))" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <div
                    class="content max-h-0 overflow-hidden bg-gradient-to-b from-gray-50 to-white border-t border-gray-200 transition-all duration-500 ease-in-out">
                    <div class="p-8">
                        <p class="text-green-700 font-semibold mb-6 flex items-center gap-2">
                            <i class="bi bi-person-fill"></i> Kantor Alumni IAIT
                        </p>
                        <div
                            class="bg-gradient-to-r from-green-50 to-emerald-50 p-8 rounded-2xl mb-8 text-sm text-gray-700 space-y-3 border border-green-100">
                            <p><strong class="text-green-800">Lokasi:</strong> {{ $agenda->lokasi ?? 'IAIT Tasikmalaya' }}</p>
                            <p><strong class="text-green-800">Waktu:</strong>
                                {{ \Carbon\Carbon::parse($agenda->tanggal_mulai)->format('l, d F Y') }}
                                @if($agenda->tanggal_selesai) (s/d
                                {{ \Carbon\Carbon::parse($agenda->tanggal_selesai)->format('d F Y') }}) @endif
                            </p>
                        </div>
                        <img src="{{ $agenda->gambar ? asset('storage/' . $agenda->gambar) : asset('images/L.jpeg') }}"
                            alt="{{ $agenda->judul }}"
                            class="rounded-2xl w-full max-w-3xl mx-auto block mb-8 shadow-xl object-cover">
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($agenda->deskripsi)) !!}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-20">
                <i class="bi bi-calendar-x text-6xl text-gray-300 mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum ada agenda</h3>
                <p class="text-gray-600 mb-8">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            Klik "Tambah Agenda" untuk membuat yang pertama
                        @else
                            Belum ada agenda yang tersedia.
                        @endif
                    @else
                        Belum ada agenda yang tersedia.
                    @endauth
                </p>
            </div>
        @endforelse
    </section>

    {{-- Modal Form Tambah/Edit (Admin Only) --}}
    @auth
        @if(auth()->user()->role === 'admin')
            <div id="formModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4"
                onclick="closeModal(event)">
                <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
                    onclick="event.stopPropagation()">
                    <div class="p-8 border-b border-gray-200">
                        <h2 id="modalTitle" class="text-3xl font-bold text-gray-800 mb-2">Tambah Agenda</h2>
                        <p id="modalSubtitle" class="text-gray-600">Isi detail lengkap</p>
                    </div>
                    <form id="agendaForm" enctype="multipart/form-data" class="p-8 space-y-6">
                        @csrf
                        <input type="hidden" name="_method" id="methodField">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="judul" required id="judulField"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Mulai <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_mulai" required id="tanggalMulaiField"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Selesai</label>
                                <input type="date" name="tanggal_selesai" id="tanggalSelesaiField"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi</label>
                                <input type="text" name="lokasi" id="lokasiField"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar</label>
                            <input type="file" name="gambar" accept="image/*" id="gambarField"
                                class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl hover:border-green-300">
                            <div id="currentImage" class="mt-2 p-4 bg-gray-50 rounded-xl hidden">
                                <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                                <img id="currentImagePreview" class="max-w-full h-32 object-cover rounded-xl">
                            </div>
                        </div>
                        <div class="col-span-full">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi <span
                                    class="text-red-500">*</span></label>
                            <textarea name="deskripsi" required rows="5" id="deskripsiField"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-vertical"></textarea>
                        </div>
                        <div class="flex gap-4 pt-6 border-t">
                            <button type="button" onclick="closeFormModal()"
                                class="flex-1 px-8 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-xl transition-all">Batal</button>
                            <button type="submit" id="submitBtn"
                                class="flex-1 px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg transition-all">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Modal Konfirmasi Hapus Satu --}}
            <div id="deleteSingleModal"
                class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4"
                onclick="closeDeleteSingleModal()">
                <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 text-center" onclick="event.stopPropagation()">
                    <div class="w-20 h-20 bg-red-100 rounded-3xl mx-auto mb-6 flex items-center justify-center">
                        <i class="bi bi-exclamation-triangle text-3xl text-red-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Hapus?</h3>
                    <p class="text-gray-600 mb-8">" <span id="deleteTitle"></span> " akan hilang permanen.</p>
                    <div class="flex gap-4">
                        <button onclick="closeDeleteSingleModal()"
                            class="flex-1 px-8 py-3 bg-gray-200 hover:bg-gray-300 font-bold rounded-xl transition-all">Batal</button>
                        <form id="deleteSingleForm" method="POST" style="display:contents;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex-1 px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg transition-all">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal Konfirmasi Hapus Semua --}}
            <div id="deleteAllModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4"
                onclick="closeDeleteAllModal()">
                <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 text-center" onclick="event.stopPropagation()">
                    <div class="w-20 h-20 bg-red-100 rounded-3xl mx-auto mb-6 flex items-center justify-center">
                        <i class="bi bi-exclamation-triangle text-3xl text-red-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Hapus Semua?</h3>
                    <p class="text-gray-600 mb-8">Semua agenda akan hilang permanen.</p>
                    <div class="flex gap-4">
                        <button onclick="closeDeleteAllModal()"
                            class="flex-1 px-8 py-3 bg-gray-200 hover:bg-gray-300 font-bold rounded-xl transition-all">Batal</button>
                        <form action="{{ route('agenda.destroyAll') }}" method="POST" style="display:contents;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex-1 px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg transition-all">Hapus
                                Semua</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    <script>
        // Toggle buka/tutup detail agenda
        function toggleAgenda(card) {
            const content = card.querySelector('.content');
            const arrow = card.querySelector('.arrow-down');
            const isOpen = card.classList.contains('open');

            if (isOpen) {
                content.style.maxHeight = null;
                arrow.classList.remove('rotate-180');
                card.classList.remove('open');
            } else {
                // Tutup yang lain (opsional)
                document.querySelectorAll('.agenda-card.open').forEach(c => {
                    if (c !== card) {
                        c.querySelector('.content').style.maxHeight = null;
                        c.querySelector('.arrow-down').classList.remove('rotate-180');
                        c.classList.remove('open');
                    }
                });
                content.style.maxHeight = content.scrollHeight + 'px';
                arrow.classList.add('rotate-180');
                card.classList.add('open');
                setTimeout(() => card.scrollIntoView({ behavior: 'smooth', block: 'center' }), 300);
            }
        }

        // Buka agenda jika ada hash di URL
        document.addEventListener('DOMContentLoaded', function () {
            const hash = window.location.hash;
            if (hash) {
                const target = document.querySelector(hash);
                if (target && target.classList.contains('agenda-card')) {
                    setTimeout(() => toggleAgenda(target), 400);
                }
            }
        });

        @auth
            @if(auth()->user()->role === 'admin')
                // Fungsi edit
                function openEditModal(id) {
                    fetch(`/alumni/agenda/${id}`)
                        .then(r => {
                            if (!r.ok) throw new Error('Gagal mengambil data');
                            return r.json();
                        })
                        .then(d => {
                            document.getElementById('judulField').value = d.judul || '';
                            document.getElementById('lokasiField').value = d.lokasi || '';
                            document.getElementById('tanggalMulaiField').value = d.tanggal_mulai ? d.tanggal_mulai.split(' ')[0] : '';
                            document.getElementById('tanggalSelesaiField').value = d.tanggal_selesai ? d.tanggal_selesai.split(' ')[0] : '';
                            document.getElementById('deskripsiField').value = d.deskripsi || '';
                            if (d.gambar) {
                                document.getElementById('currentImage').classList.remove('hidden');
                                document.getElementById('currentImagePreview').src = '{{ asset("storage/") }}' + '/' + d.gambar;
                            } else {
                                document.getElementById('currentImage').classList.add('hidden');
                            }
                            document.getElementById('agendaForm').action = `/alumni/agenda/${id}`;
                            document.getElementById('methodField').value = 'PUT';
                            document.getElementById('modalTitle').textContent = 'Edit "' + (d.judul || 'Agenda') + '"';
                            document.getElementById('submitBtn').textContent = 'Update';
                            document.getElementById('formModal').classList.remove('hidden');
                        })
                        .catch(err => alert('Gagal load data: ' + err.message));
                }

                // Konfirmasi hapus satu
                function confirmDelete(id) {
                    const card = document.getElementById(`agenda-${id}`);
                    const title = card ? card.querySelector('h3').textContent.trim() : 'Agenda ini';
                    document.getElementById('deleteTitle').textContent = title;
                    document.getElementById('deleteSingleForm').action = `/alumni/agenda/${id}`;
                    document.getElementById('deleteSingleModal').classList.remove('hidden');
                }

                // Buka modal tambah
                function openCreateModal() {
                    document.getElementById('modalTitle').textContent = 'Tambah Agenda';
                    document.getElementById('submitBtn').textContent = 'Tambah';
                    document.getElementById('agendaForm').action = "{{ route('alumni.agenda.store') }}";
                    document.getElementById('methodField').value = '';
                    document.getElementById('currentImage').classList.add('hidden');
                    document.getElementById('agendaForm').reset();
                    document.getElementById('formModal').classList.remove('hidden');
                }

                // Submit form via AJAX
                document.addEventListener('DOMContentLoaded', function () {
                    const form = document.getElementById('agendaForm');
                    if (form) {
                        form.addEventListener('submit', function (e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            const submitBtn = document.getElementById('submitBtn');
                            const originalText = submitBtn.textContent;
                            submitBtn.textContent = 'Menyimpan...';
                            submitBtn.disabled = true;

                            fetch(this.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                                .then(r => {
                                    if (!r.ok) return r.text().then(t => { throw new Error(r.status + ' - ' + t); });
                                    return r.text();
                                })
                                .then(() => location.reload())
                                .catch(err => {
                                    alert('Gagal simpan: ' + err.message);
                                    submitBtn.textContent = originalText;
                                    submitBtn.disabled = false;
                                });
                        });
                    }
                });

                // Fungsi tutup modal
                function closeModal(e) {
                    if (e) e.stopPropagation();
                    document.getElementById('formModal').classList.add('hidden');
                    document.getElementById('deleteSingleModal').classList.add('hidden');
                    document.getElementById('deleteAllModal').classList.add('hidden');
                    document.getElementById('agendaForm').reset();
                    document.getElementById('currentImage').classList.add('hidden');
                }
                function closeFormModal() { closeModal(); }
                function closeDeleteSingleModal() { document.getElementById('deleteSingleModal').classList.add('hidden'); }
                function closeDeleteAllModal() { document.getElementById('deleteAllModal').classList.add('hidden'); }
                function openDeleteAllModal() { document.getElementById('deleteAllModal').classList.remove('hidden'); }
            @endif
        @endauth
    </script>

@endsection