@extends('layouts.app')

@section('title', 'Beranda - Alumni IAIT')

@push('styles')
    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        /* === GLOBAL SLIDER STYLING (BIAR RAPI) === */
        .slider-section {
            overflow: hidden;
            padding: 0 4px;
            margin: 0 -4px;
        }

        .swiper {
            overflow: visible !important;
            padding: 10px 0 20px 0 !important; /* Ruang buat shadow & pagination */
        }

        /* Lebar card tetap, tidak melebar */
        .swiper-slide {
            width: 300px !important;
            height: auto;
            box-sizing: border-box;
        }

        @media (max-width: 640px) {
            .swiper-slide {
                width: 260px !important;
            }
        }

        /* === CARD STYLING UNIFORM (BIAR SEMUA SECTION SAMA TINGGINYA) === */
        .uniform-card {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            transition: all 0.2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(0,0,0,0.03);
        }
        .uniform-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }

        /* Gambar dalam card (Agenda & Berita) */
        .card-img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            background-color: #f3f4f6;
        }

        /* Konten dalam card */
        .card-content {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Pagination styling */
        .swiper-pagination {
            position: relative !important;
            margin-top: 1.5rem !important;
            bottom: auto !important;
        }
        .swiper-pagination-bullet-active {
            background-color: #16a34a !important; /* green-600 */
        }

        /* Hero navigation */
        .heroSwiper .swiper-button-prev,
        .heroSwiper .swiper-button-next {
            color: white !important;
        }
        
        /* Line clamp utility */
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Testimoni Avatar */
        .testi-avatar {
            width: 48px;
            height: 48px;
            border-radius: 9999px;
            object-fit: cover;
            border: 2px solid #e5e7eb;
        }

        /* Lowongan border accent */
        .lowongan-accent {
            border-left: 5px solid #22c55e;
        }
    </style>
@endpush

@section('content')
<div class="bg-gray-50">

    {{-- 1. HERO CAROUSEL FULL GAMBAR --}}
<section class="relative">
    <div class="swiper heroSwiper h-screen">
        <div class="swiper-wrapper">
            {{-- Slide 1 --}}
            <div class="swiper-slide">
                <div class="relative w-full h-full bg-cover bg-center" style="background-image: url('{{ asset('images/branda.jpg') }}')">
                    {{-- Overlay sangat tipis hanya untuk teks, bisa diatur opacity 0.2 --}}
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="relative z-10 h-full flex items-center justify-center text-white text-center px-4">
                        <div class="max-w-4xl" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.7);">
                            <h1 class="text-3xl md:text-5xl font-bold mb-4">SELAMAT DATANG DI WEBSITE ALUMNI</h1>
                            <h2 class="text-xl md:text-2xl mb-6">INSTITUT AGAMA ISLAM TASIKMALAYA</h2>
                            <p class="text-lg">Temukan teman satu angkatan, ikuti event serta bangun koneksi bersama Alumni!</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Slide 2 --}}
            <div class="swiper-slide">
                <div class="relative w-full h-full bg-cover bg-center" style="background-image: url('{{ asset('images/slide2.jpg') }}')">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="relative z-10 h-full flex items-center justify-center text-white text-center px-4">
                        <div class="max-w-3xl" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.7);">
                            <h2 class="text-3xl md:text-4xl font-bold mb-4">Koneksi Alumni</h2>
                            <p class="text-lg">Bangun jaringan profesional dengan lebih dari 8.000 alumni IAIT yang sukses di berbagai bidang.</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Slide 3 --}}
            <div class="swiper-slide">
                <div class="relative w-full h-full bg-cover bg-center" style="background-image: url('{{ asset('images/slide3.jpg') }}')">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="relative z-10 h-full flex items-center justify-center text-white text-center px-4">
                        <div class="max-w-3xl" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.7);">
                            <h2 class="text-3xl md:text-4xl font-bold mb-4">Event & Agenda</h2>
                            <p class="text-lg">Ikuti reuni, seminar dan pelatihan karir eksklusif untuk alumni IAIT.</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Slide 4 --}}
            <div class="swiper-slide">
                <div class="relative w-full h-full bg-cover bg-center" style="background-image: url('{{ asset('images/slide4.jpg') }}')">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="relative z-10 h-full flex items-center justify-center text-white text-center px-4">
                        <div class="max-w-3xl" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.7);">
                            <h2 class="text-3xl md:text-4xl font-bold mb-4">Lowongan Kerja</h2>
                            <p class="text-lg">Temukan peluang karir terbaik dari perusahaan yang memprioritaskan alumni IAIT.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Pagination & Navigasi --}}
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>

    {{-- 2. TENTANG ALUMNI (Ringkas) --}}
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Tentang Alumni IAIT</h2>
                <div class="w-20 h-1 bg-green-600 mx-auto mt-2"></div>
            </div>
            @php
                $about = \App\Models\About::first();
            @endphp
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-lg text-gray-600 leading-relaxed">
                    {{ $about->deskripsi_singkat ?? 'Institut Agama Islam Tasikmalaya (IAIT) telah melahirkan ribuan alumni yang berkontribusi di berbagai bidang. Website ini hadir sebagai wadah silaturahmi dan informasi bagi seluruh alumni.' }}
                </p>
                <div class="mt-8">
                    <a href="{{ route('tentang') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                        Selengkapnya →
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. STATISTIK --}}
    <section class="py-16 bg-gray-100">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Statistik Alumni</h2>
                <div class="w-20 h-1 bg-green-600 mx-auto mt-2"></div>
            </div>
            @php
                $totalAlumni = \App\Models\Alumni::where('status', 'approved')->count();
                $bekerja = \App\Models\Alumni::where('status', 'approved')
                            ->whereNotNull('pekerjaan')
                            ->where('pekerjaan', '!=', '')
                            ->count();
                $belumBekerja = $totalAlumni - $bekerja;
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow text-center">
                    <div class="text-4xl font-bold text-green-600">{{ number_format($totalAlumni) }}</div>
                    <div class="text-gray-600 mt-2">Total Alumni</div>
                </div>
                <div class="bg-white p-8 rounded-xl shadow text-center">
                    <div class="text-4xl font-bold text-green-600">{{ number_format($bekerja) }}</div>
                    <div class="text-gray-600 mt-2">Sedang Bekerja</div>
                </div>
                <div class="bg-white p-8 rounded-xl shadow text-center">
                    <div class="text-4xl font-bold text-green-600">{{ number_format($belumBekerja) }}</div>
                    <div class="text-gray-600 mt-2">Belum Bekerja</div>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. TESTIMONI SLIDER (RAPIH) --}}
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Testimoni Alumni</h2>
                <a href="{{ route('testimoni.index') }}" class="text-green-600 hover:text-green-800 font-medium">Selengkapnya →</a>
            </div>
            <div class="slider-section">
                <div class="swiper testimoniSwiper">
                    <div class="swiper-wrapper">
                        @foreach(\App\Models\Testimoni::latest()->take(10)->get() as $testi)
                        <div class="swiper-slide">
                            <div class="uniform-card">
                                <div class="card-content">
                                    {{-- Icon kutip --}}
                                    <svg class="w-8 h-8 text-green-200 mb-3" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                    </svg>
                                    <p class="text-gray-600 italic flex-grow line-clamp-3">"{{ $testi->isi_testimoni }}"</p>
                                    <div class="flex items-center mt-5 pt-3 border-t border-gray-100">
                                        <img src="{{ $testi->foto ? asset('storage/'.$testi->foto) : asset('images/default-avatar.png') }}" 
                                             class="testi-avatar mr-3">
                                        <div>
                                            <h4 class="font-semibold text-gray-800">{{ $testi->nama }}</h4>
                                            <p class="text-sm text-gray-500">{{ $testi->jurusan }} {{ $testi->tahun_lulus }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. AGENDA SLIDER (RAPIH) --}}
    <section class="py-16 bg-gray-100">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Agenda Terbaru</h2>
                <a href="{{ route('agenda.index') }}" class="text-green-600 hover:text-green-800 font-medium">Selengkapnya →</a>
            </div>
            <div class="slider-section">
                <div class="swiper agendaSwiper">
                    <div class="swiper-wrapper">
                        @foreach(\App\Models\Agenda::latest('tanggal_mulai')->take(10)->get() as $agenda)
                        <div class="swiper-slide">
                            <div class="uniform-card">
                                @if($agenda->gambar)
                                    <img src="{{ asset('storage/'.$agenda->gambar) }}" class="card-img">
                                @else
                                    <div class="card-img bg-gray-200 flex items-center justify-center text-gray-400 text-sm">No Image</div>
                                @endif
                                <div class="card-content">
                                    <h3 class="font-bold text-lg mb-1 line-clamp-2">{{ $agenda->judul }}</h3>
                                    <p class="text-sm text-green-600 mb-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($agenda->tanggal_mulai)->format('d M Y') }}
                                        @if($agenda->tanggal_selesai) - {{ \Carbon\Carbon::parse($agenda->tanggal_selesai)->format('d M Y') }} @endif
                                    </p>
                                    <p class="text-gray-600 text-sm flex-grow">{{ Str::limit($agenda->deskripsi, 70) }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. BERITA SLIDER (RAPIH) --}}
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Berita Terbaru</h2>
                <a href="{{ route('berita.index') }}" class="text-green-600 hover:text-green-800 font-medium">Selengkapnya →</a>
            </div>
            <div class="slider-section">
                <div class="swiper beritaSwiper">
                    <div class="swiper-wrapper">
                        @foreach(\App\Models\Berita::latest()->take(10)->get() as $berita)
                        <div class="swiper-slide">
                            <div class="uniform-card">
                                @if($berita->gambar)
                                    <img src="{{ asset('storage/'.$berita->gambar) }}" class="card-img">
                                @else
                                    <div class="card-img bg-gray-200 flex items-center justify-center text-gray-400 text-sm">No Image</div>
                                @endif
                                <div class="card-content">
                                    <p class="text-xs font-medium text-green-600 mb-1">{{ \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}</p>
                                    <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $berita->judul }}</h3>
                                    <p class="text-gray-600 text-sm flex-grow">{{ Str::limit($berita->isi, 80) }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- 7. LOWONGAN SLIDER (RAPIH) --}}
    <section class="py-16 bg-gray-100">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Lowongan Kerja</h2>
                <a href="{{ route('lowongan.index') }}" class="text-green-600 hover:text-green-800 font-medium">Selengkapnya →</a>
            </div>
            <div class="slider-section">
                <div class="swiper lowonganSwiper">
                    <div class="swiper-wrapper">
                        @foreach(\App\Models\Lowongan::latest()->take(10)->get() as $lowongan)
                        <div class="swiper-slide">
                            <div class="uniform-card lowongan-accent">
                                <div class="card-content">
                                    <h3 class="font-bold text-xl mb-1 text-gray-800">{{ $lowongan->judul }}</h3>
                                    <p class="text-green-700 font-medium text-sm mb-2">{{ $lowongan->perusahaan }}</p>
                                    <div class="flex items-center text-gray-500 text-sm mb-3">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $lowongan->lokasi }}
                                    </div>
                                    <p class="text-gray-600 text-sm flex-grow line-clamp-3">{{ $lowongan->deskripsi }}</p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">{{ $lowongan->tipe }}</span>
                                        <span class="text-xs text-gray-400">{{ $lowongan->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Hero Carousel
            new Swiper('.heroSwiper', {
                loop: true,
                autoplay: { delay: 4000, disableOnInteraction: false },
                pagination: { el: '.heroSwiper .swiper-pagination', clickable: true },
                navigation: { nextEl: '.heroSwiper .swiper-button-next', prevEl: '.heroSwiper .swiper-button-prev' },
            });

            // Fungsi inisialisasi slider seragam
            const initSlider = (selector) => {
                return new Swiper(selector, {
                    slidesPerView: 'auto',
                    spaceBetween: 20,
                    pagination: { el: `${selector} .swiper-pagination`, clickable: true },
                    freeMode: true,
                    grabCursor: true,
                });
            };

            initSlider('.testimoniSwiper');
            initSlider('.agendaSwiper');
            initSlider('.beritaSwiper');
            initSlider('.lowonganSwiper');
        });
    </script>
@endpush