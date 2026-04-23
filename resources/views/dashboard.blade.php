@extends('layouts.app')

@section('title', 'Beranda - Alumni IAIT')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        /* HERO */
        .hero-wrap {
            position: relative;
            width: 100%;
            height: 400px;
            overflow: hidden;
        }

        .heroSwiper,
        .heroSwiper .swiper-wrapper,
        .heroSwiper .swiper-slide {
            width: 100%;
            height: 100%;
        }

        .heroSwiper .swiper-slide {
            position: relative;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .heroSwiper .swiper-button-prev,
        .heroSwiper .swiper-button-next {
            color: #fff !important;
        }

        .heroSwiper .swiper-pagination-bullet-active {
            background: #fff !important;
        }

        /* SECTION HEADER */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 1.25rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
        }

        .section-bar {
            width: 3rem;
            height: 3px;
            background: #16a34a;
            margin-top: 0.35rem;
        }

        .scroll-nav {
            display: flex;
            gap: 0.4rem;
        }

        .scroll-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1.5px solid #16a34a;
            background: #fff;
            color: #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .15s;
            flex-shrink: 0;
        }

        .scroll-btn:hover {
            background: #16a34a;
            color: #fff;
        }

        /* SCROLL TRACK */
        .cards-track {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            overflow-y: visible;
            padding: 0.5rem 0 1rem;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            align-items: stretch;
        }

        .cards-track::-webkit-scrollbar {
            display: none;
        }

        /* CARD BASE */
        .card {
            flex: 0 0 200px;
            scroll-snap-align: start;
            background: #fff;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            transition: transform .2s, box-shadow .2s;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(0, 0, 0, 0.05);
            text-decoration: none;
            color: inherit;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.11);
        }

        .card-img {
            width: 100%;
            height: 110px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .card-img-ph {
            width: 100%;
            height: 110px;
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #86efac;
            flex-shrink: 0;
        }

        .card-body {
            padding: 0.75rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .card-title {
            font-weight: 700;
            font-size: 0.8rem;
            color: #1f2937;
            line-height: 1.3;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .card-meta {
            font-size: 0.68rem;
            color: #9ca3af;
        }

        .card-green {
            font-size: 0.68rem;
            color: #16a34a;
            font-weight: 600;
        }

        .card-desc {
            font-size: 0.7rem;
            color: #6b7280;
            line-height: 1.4;
            flex: 1;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .clamp2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .clamp3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* TESTIMONI CARD */
        .testi-card {
            flex: 0 0 200px;
            height: 220px;
            scroll-snap-align: start;
            background: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            border: 1px solid rgba(0, 0, 0, 0.05);
            padding: 0.85rem;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            transition: transform .2s, box-shadow .2s;
            text-decoration: none;
            color: inherit;
            cursor: pointer;
            overflow: hidden;
        }

        .testi-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.11);
        }

        .testi-avatar {
            width: 32px;
            height: 32px;
            border-radius: 9999px;
            object-fit: cover;
            border: 2px solid #e5e7eb;
            flex-shrink: 0;
        }

        .lowongan-card {
            border-left: 3px solid #22c55e;
        }

        /* SEE MORE */
        .card-more {
            flex: 0 0 120px;
            scroll-snap-align: start;
            border-radius: 0.75rem;
            border: 2px dashed #bbf7d0;
            background: #f0fdf4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            color: #16a34a;
            font-weight: 600;
            font-size: 0.72rem;
            text-align: center;
            text-decoration: none;
            padding: 1rem 0.75rem;
            transition: all .2s;
        }

        .card-more:hover {
            background: #dcfce7;
            border-color: #16a34a;
            transform: translateY(-3px);
        }

        .badge {
            display: inline-block;
            padding: 0.15rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.62rem;
            font-weight: 600;
            background: #dcfce7;
            color: #166534;
        }
    </style>
@endpush

@section('content')
    <div class="bg-gray-50">

        {{-- HERO — pure image, zero text --}}
        <div class="hero-wrap">
            <div class="swiper heroSwiper">
                <div class="swiper-wrapper">
                    @forelse($heroSlides as $s)
                        <div class="swiper-slide" style="background-image:url('{{ Storage::url($s->gambar) }}')"></div>
                    @empty
                        {{-- Fallback kalau DB kosong --}}
                        <div class="swiper-slide" style="background-image:url('{{ asset('images/branda.jpg') }}')"></div>
                    @endforelse
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>

            {{-- Button Kelola Slider — admin only --}}
            @if(auth()->check() && trim(auth()->user()->role) === 'admin')
                <a href="{{ route('admin.hero.index') }}"
                    class="absolute bottom-6 right-6 z-10 bg-white bg-opacity-90 hover:bg-opacity-100 text-green-700 font-semibold text-xs px-4 py-2 rounded-full shadow-lg transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Kelola Slider
                </a>
            @endif
        </div>

        {{-- TENTANG --}}
        <section class="py-12 bg-white">
            <div class="max-w-5xl mx-auto px-4 text-center">
                <h2 class="text-2xl font-bold text-gray-800">Tentang Alumni IAIT</h2>
                <div class="w-14 h-1 bg-green-600 mx-auto mt-2 mb-5"></div>
                <p class="text-gray-600 leading-relaxed max-w-2xl mx-auto text-sm">
                    {{ $about->deskripsi_singkat ?? 'Institut Agama Islam Tasikmalaya (IAIT) telah melahirkan ribuan alumni yang berkontribusi di berbagai bidang.' }}
                </p>
                <a href="{{ route('tentang') }}"
                    class="inline-block mt-6 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2.5 px-5 rounded-lg transition">
                    Selengkapnya →
                </a>
            </div>
        </section>

        {{-- STATISTIK --}}
        <section class="py-10 bg-gray-100">
            <div class="max-w-5xl mx-auto px-4">
                <h2 class="text-2xl font-bold text-gray-800 text-center">Statistik Alumni</h2>
                <div class="w-14 h-1 bg-green-600 mx-auto mt-2 mb-7"></div>
                <div class="grid grid-cols-3 gap-4">
                    @foreach([['val' => $totalAlumni, 'label' => 'Total Alumni'], ['val' => $bekerja, 'label' => 'Sedang Bekerja'], ['val' => $totalAlumni - $bekerja, 'label' => 'Belum Bekerja']] as $st)
                        <div class="bg-white rounded-xl shadow p-5 text-center">
                            <div class="text-3xl font-bold text-green-600">{{ number_format($st['val']) }}</div>
                            <div class="text-gray-500 text-sm mt-1">{{ $st['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- TESTIMONI --}}
        <section class="py-10 bg-white">
            <div class="max-w-5xl mx-auto px-4">
                <div class="section-header">
                    <div>
                        <div class="section-title">Testimoni Alumni</div>
                        <div class="section-bar"></div>
                    </div>
                    <div class="scroll-nav">
                        <button class="scroll-btn" onclick="sc('testi-track',-1)"><svg class="w-3.5 h-3.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 19l-7-7 7-7" />
                            </svg></button>
                        <button class="scroll-btn" onclick="sc('testi-track',1)"><svg class="w-3.5 h-3.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg></button>
                    </div>
                </div>
                <div id="testi-track" class="cards-track">
                    @forelse($testimonis as $t)
                        <a href="{{ route('testimoni.index') }}#testimoni-{{ $t->id }}" class="testi-card">
                            <svg class="w-5 h-5 text-green-200 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                            <p class="card-desc clamp3 italic" style="word-break:break-word; overflow-wrap:break-word;">
                                "{{ $t->isi_testimoni }}"
                            </p>
                            <div class="flex items-center gap-2 pt-2 border-t border-gray-100 mt-auto">
                                <img src="{{ $t->foto ? asset('storage/' . $t->foto) : asset('images/default-avatar.png') }}"
                                    class="testi-avatar" alt="{{ $t->nama }}">
                                <div>
                                    <div style="font-size:0.73rem;font-weight:700;color:#1f2937">{{ $t->nama }}</div>
                                    <div class="card-meta">{{ $t->jurusan }} · {{ $t->tahun_lulus }}</div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-400 text-sm italic">Belum ada testimoni.</p>
                    @endforelse
                    @if($testimonis->count() >= 7)
                        <a href="{{ route('testimoni.index') }}" class="card-more"><svg class="w-6 h-6" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>Lihat Semua</a>
                    @endif
                </div>
            </div>
        </section>

        {{-- AGENDA --}}
        <section class="py-10 bg-gray-100">
            <div class="max-w-5xl mx-auto px-4">
                <div class="section-header">
                    <div>
                        <div class="section-title">Agenda Terbaru</div>
                        <div class="section-bar"></div>
                    </div>
                    <div class="scroll-nav">
                        <button class="scroll-btn" onclick="sc('agenda-track',-1)"><svg class="w-3.5 h-3.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 19l-7-7 7-7" />
                            </svg></button>
                        <button class="scroll-btn" onclick="sc('agenda-track',1)"><svg class="w-3.5 h-3.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg></button>
                    </div>
                </div>
                <div id="agenda-track" class="cards-track">
                    @forelse($agendas as $a)
                        <a href="{{ route('agenda.index') }}#agenda-{{ $a->id }}" class="card">
                            @if($a->gambar)
                                <img src="{{ asset('storage/' . $a->gambar) }}" class="card-img" alt="{{ $a->judul }}"
                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                <div class="card-img-ph" style="display:none"><svg class="w-7 h-7" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg></div>
                            @else
                                <div class="card-img-ph"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg></div>
                            @endif
                            <div class="card-body">
                                <div class="card-green">
                                    {{ \Carbon\Carbon::parse($a->tanggal_mulai)->format('d M Y') }}@if($a->tanggal_selesai) –
                                    {{ \Carbon\Carbon::parse($a->tanggal_selesai)->format('d M Y') }}@endif</div>
                                <div class="card-title clamp2">{{ $a->judul }}</div>
                                <div class="card-desc clamp3">{{ strip_tags($a->deskripsi) }}</div>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-400 text-sm italic">Belum ada agenda.</p>
                    @endforelse
                    @if($agendas->count() >= 7)
                        <a href="{{ route('agenda.index') }}" class="card-more"><svg class="w-6 h-6" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>Lihat Semua</a>
                    @endif
                </div>
            </div>
        </section>

        {{-- BERITA --}}
        <section class="py-10 bg-white">
            <div class="max-w-5xl mx-auto px-4">
                <div class="section-header">
                    <div>
                        <div class="section-title">Berita Terbaru</div>
                        <div class="section-bar"></div>
                    </div>
                    <div class="scroll-nav">
                        <button class="scroll-btn" onclick="sc('berita-track',-1)"><svg class="w-3.5 h-3.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 19l-7-7 7-7" />
                            </svg></button>
                        <button class="scroll-btn" onclick="sc('berita-track',1)"><svg class="w-3.5 h-3.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg></button>
                    </div>
                </div>
                <div id="berita-track" class="cards-track">
                    @forelse($beritas as $b)
                        <a href="{{ route('berita.show', $b->id) }}" class="card">
                            @if($b->gambar)
                                <img src="{{ asset('storage/' . $b->gambar) }}" class="card-img" alt="{{ $b->judul }}"
                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                <div class="card-img-ph" style="display:none"><svg class="w-7 h-7" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg></div>
                            @else
                                <div class="card-img-ph"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg></div>
                            @endif
                            <div class="card-body">
                                <div class="card-green">{{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }}</div>
                                <div class="card-title clamp2">{{ $b->judul }}</div>
                                <div class="card-desc clamp3">{{ strip_tags($b->isi) }}</div>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-400 text-sm italic">Belum ada berita.</p>
                    @endforelse
                    @if($beritas->count() >= 7)
                        <a href="{{ route('berita.index') }}" class="card-more"><svg class="w-6 h-6" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>Lihat Semua</a>
                    @endif
                </div>
            </div>
        </section>

        {{-- LOWONGAN --}}
        <section class="py-10 bg-gray-100">
            <div class="max-w-5xl mx-auto px-4">
                <div class="section-header">
                    <div>
                        <div class="section-title">Lowongan Kerja</div>
                        <div class="section-bar"></div>
                    </div>
                    <div class="scroll-nav">
                        <button class="scroll-btn" onclick="sc('lowongan-track',-1)"><svg class="w-3.5 h-3.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 19l-7-7 7-7" />
                            </svg></button>
                        <button class="scroll-btn" onclick="sc('lowongan-track',1)"><svg class="w-3.5 h-3.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg></button>
                    </div>
                </div>
                <div id="lowongan-track" class="cards-track">
                    @forelse($lowongans as $l)
                        <a href="{{ route('lowongan.show', $l) }}" class="card lowongan-card">
                            @if($l->gambar)
                                <img src="{{ asset('storage/' . $l->gambar) }}" class="card-img" alt="{{ $l->judul }}">
                            @else
                                <div class="card-img-ph">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6a4 4 0 11-8 0 4 4 0 018 0zM12 11a4 4 0 100-8 4 4 0 000 8z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="card-title clamp2">{{ $l->judul }}</div>
                                <div class="card-green">{{ $l->perusahaan }}</div>
                                <div class="card-meta flex items-center gap-1">
                                    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $l->lokasi }}
                                </div>
                                <div class="card-desc clamp3">{{ strip_tags($l->deskripsi) }}</div>
                                <div class="flex items-center justify-between mt-auto pt-2">
                                    <span class="badge">{{ $l->tipe }}</span>
                                    <span class="card-meta">{{ $l->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-400 text-sm italic">Belum ada lowongan.</p>
                    @endforelse
                    @if($lowongans->count() >= 7)
                        <a href="{{ route('lowongan.index') }}" class="card-more"><svg class="w-6 h-6" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>Lihat Semua</a>
                    @endif
                </div>
            </div>
        </section>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        new Swiper('.heroSwiper', {
            loop: true,
            autoplay: { delay: 4000, disableOnInteraction: false },
            pagination: { el: '.heroSwiper .swiper-pagination', clickable: true },
            navigation: { nextEl: '.heroSwiper .swiper-button-next', prevEl: '.heroSwiper .swiper-button-prev' },
        });

        function sc(id, dir) {
            document.getElementById(id).scrollBy({ left: dir * 220, behavior: 'smooth' });
        }
    </script>
@endpush