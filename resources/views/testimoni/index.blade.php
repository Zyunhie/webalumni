@extends('layouts.app')

@section('title', 'Testimoni Alumni')

@section('content')
    <section class="relative h-[360px] bg-cover bg-center overflow-hidden"
        style="background-image: url('{{ $HeroTestimoni ? Storage::url($HeroTestimoni->gambar) : asset('images/Branda.jpg') }}');">
        <div class="absolute inset-0 bg-gradient-to-r from-gray-950/80 via-gray-900/50 to-transparent"></div>
        <div class="relative z-10 max-w-6xl mx-auto h-full px-6 flex items-center">
            <div class="max-w-2xl text-white">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-green-200 mb-3">Cerita Alumni</p>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">Testimoni Alumni</h1>
                <p class="mt-4 text-white/80 text-base md:text-lg">Pengalaman kuliah, perjalanan karier, dan dampak nyata dari alumni yang sudah melewati proses review.</p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="#testimoni-grid" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition">
                        Lihat Testimoni
                    </a>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.testimoni.pending') }}"
                                class="bg-white/95 hover:bg-white text-gray-900 px-5 py-2.5 rounded-lg font-semibold text-sm transition">
                                Review Testimoni
                            </a>
                        @else
                            <a href="{{ $myTestimonial ? route('testimoni.edit', $myTestimonial) : route('testimoni.create') }}"
                                class="bg-white/95 hover:bg-white text-gray-900 px-5 py-2.5 rounded-lg font-semibold text-sm transition">
                                {{ $myTestimonial ? 'Kelola Testimoni Saya' : 'Kirim Testimoni' }}
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-white/95 hover:bg-white text-gray-900 px-5 py-2.5 rounded-lg font-semibold text-sm transition">
                            Login untuk Mengirim
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        @if(auth()->check() && trim(auth()->user()->role) === 'admin')
            <a href="{{ route('admin.hero.index') }}"
                class="absolute bottom-4 right-4 z-10 bg-white/90 hover:bg-white text-green-700 font-semibold text-xs px-4 py-2 rounded-lg shadow-lg transition">
                Kelola Slider
            </a>
        @endif
    </section>

    <section class="bg-white border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-6 py-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border border-gray-100 rounded-xl p-5 bg-gray-50">
                <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['approved']) }}</div>
                <div class="text-sm text-gray-500 mt-1">Sudah dipublikasikan</div>
            </div>
            <div class="border border-gray-100 rounded-xl p-5 bg-gray-50">
                <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['pending']) }}</div>
                <div class="text-sm text-gray-500 mt-1">Menunggu review admin</div>
            </div>
            <div class="border border-gray-100 rounded-xl p-5 bg-gray-50">
                <div class="text-2xl font-bold text-gray-900">{{ number_format($testimonials->total()) }}</div>
                <div class="text-sm text-gray-500 mt-1">Hasil sesuai pencarian</div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 py-12">
        @if(session('success'))
            <div id="success-toast" class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm transition-opacity duration-300">
                <div class="font-bold">{{ session('success') }}</div>
                @if(session('success_detail'))
                    <div class="text-xs text-green-600 mt-0.5">{{ session('success_detail') }}</div>
                @endif
            </div>
        @endif

        @if($myTestimonial && auth()->user()->role !== 'admin')
            <div class="mb-8 border border-gray-200 bg-white rounded-xl p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="font-bold text-gray-900">Testimoni Saya</h2>
                        <span class="inline-flex px-2.5 py-1 rounded-full border text-xs font-semibold {{ $myTestimonial->status_badge_class }}">
                            {{ $myTestimonial->status_label }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">
                        @if($myTestimonial->status === 'approved')
                            Testimoni Anda sedang tampil di halaman publik.
                        @elseif($myTestimonial->status === 'rejected')
                            Testimoni perlu direvisi sebelum dapat dipublikasikan.
                        @else
                            Testimoni Anda sedang dalam antrean review admin.
                        @endif
                    </p>
                </div>
                <a href="{{ route('testimoni.edit', $myTestimonial) }}" class="inline-flex justify-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                    Kelola
                </a>
            </div>
        @endif

        <form method="GET" class="mb-10">
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, prodi, pekerjaan, perusahaan, atau isi testimoni..."
                    class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-200 focus:border-green-500 text-sm outline-none">
                <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-3 rounded-xl font-semibold text-sm transition">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('testimoni.index') }}" class="border border-gray-200 hover:bg-gray-50 text-gray-600 px-5 py-3 rounded-xl font-semibold text-sm text-center transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <div id="testimoni-grid">
            @if($testimonials->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($testimonials as $t)
                        <article id="testimoni-{{ $t->id }}" class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden flex flex-col">
                            <div class="p-5 flex items-center gap-4 border-b border-gray-100">
                                <div class="w-14 h-14 rounded-full overflow-hidden bg-green-50 flex items-center justify-center shrink-0">
                                    @if($t->foto)
                                        <img src="{{ Storage::url($t->foto) }}" alt="{{ $t->nama }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-green-700 font-bold text-xl">{{ strtoupper(substr($t->nama, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-bold text-gray-900 truncate">{{ $t->nama }}</h3>
                                    <p class="text-xs text-gray-500 truncate">{{ $t->jurusan ?? 'Alumni' }}{{ $t->tahun_lulus ? ' - Lulus '.$t->tahun_lulus : '' }}</p>
                                </div>
                            </div>

                            <div class="p-5 flex flex-col flex-1">
                                <p class="text-gray-700 text-sm leading-relaxed line-clamp-6 break-words flex-1">"{{ $t->isi_testimoni }}"</p>
                                <div class="mt-5 pt-4 border-t border-gray-100 flex items-end justify-between gap-3">
                                    <div class="text-xs text-gray-500 min-w-0">
                                        <div class="font-semibold text-gray-700 truncate">{{ $t->pekerjaan ?? 'Alumni' }}</div>
                                        @if($t->perusahaan)
                                            <div class="truncate">{{ $t->perusahaan }}</div>
                                        @endif
                                    </div>
                                    <span class="text-[11px] text-gray-400 shrink-0">{{ optional($t->approved_at ?? $t->created_at)->diffForHumans() }}</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $testimonials->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-white border border-gray-100 rounded-xl">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada testimoni yang cocok</h3>
                    <p class="text-gray-500 mb-6">Coba kata kunci lain atau jadilah alumni pertama yang mengirim cerita.</p>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.testimoni.pending') }}" class="inline-flex bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg transition">
                                Review Testimoni
                            </a>
                        @else
                            <a href="{{ $myTestimonial ? route('testimoni.edit', $myTestimonial) : route('testimoni.create') }}"
                                class="inline-flex bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg transition">
                                {{ $myTestimonial ? 'Kelola Testimoni Saya' : 'Kirim Testimoni' }}
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="inline-flex border border-green-600 text-green-700 hover:bg-green-50 font-semibold px-5 py-2.5 rounded-lg transition">
                            Login untuk Mengirim
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        setTimeout(function () {
            var toast = document.getElementById('success-toast');
            if (!toast) return;

            toast.classList.add('opacity-0');
            setTimeout(function () {
                toast.remove();
            }, 300);
        }, 2000);
    </script>
@endpush
