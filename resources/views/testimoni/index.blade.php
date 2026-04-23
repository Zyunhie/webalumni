@extends('layouts.app')

@section('title', 'Testimoni Alumni')

@section('content')

    <section class="relative h-[400px] bg-cover bg-center overflow-hidden"
        style="background-image: url('{{ $HeroTestimoni ? Storage::url($HeroTestimoni->gambar) : asset('images/Branda.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-white">
            <h1 class="text-4xl font-bold">Testimoni Alumni</h1>
            <p class="mt-2 text-sm">
                <a href="{{ route('home') }}" class="hover:underline">Beranda</a> > Testimoni
            </p>
        </div>

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

    <section class="bg-white border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-6 py-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 leading-tight">Testimoni Alumni</h1>
                <p class="text-gray-500 mt-1">Cerita Sukses dan Pengalaman Alumni Kami</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="#testimoni-grid"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-full font-semibold text-sm transition text-center">
                    Lihat Testimoni
                </a>
                @auth
                    <a href="{{ route('testimoni.create') }}"
                        class="border border-green-600 text-green-600 hover:bg-green-600 hover:text-white px-6 py-2.5 rounded-full font-semibold text-sm transition text-center">
                        + Tambah Testimoni
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="border border-green-600 text-green-600 hover:bg-green-600 hover:text-white px-6 py-2.5 rounded-full font-semibold text-sm transition text-center">
                        Login untuk Tambah
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 py-12">

        <form method="GET" class="max-w-md mx-auto mb-10">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau testimoni..."
                    class="w-full pl-12 pr-6 py-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-green-200 focus:border-green-500 text-base">
                <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-8 rounded-2xl shadow-xl text-center">
                <div class="text-3xl font-bold">{{ $testimonials->total() }}</div>
                <div class="text-base mt-2">Testimoni Tersedia</div>
            </div>
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-8 rounded-2xl shadow-xl text-center">
                <div class="text-3xl font-bold">{{ number_format(\App\Models\Testimonials::approved()->count()) }}</div>
                <div class="text-base mt-2">Approved</div>
            </div>
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('admin.testimoni.pending') }}"
                    class="bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-8 rounded-2xl shadow-xl text-center transition transform hover:-translate-y-1 block">
                    <div class="text-3xl font-bold">
                        {{ number_format(\App\Models\Testimonials::where('status', 'pending')->count()) }}</div>
                    <div class="text-base mt-2">Pending Admin</div>
                    <div class="text-xs mt-1 opacity-75">Klik untuk review →</div>
                </a>
            @else
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-8 rounded-2xl shadow-xl text-center">
                    <div class="text-3xl font-bold">
                        {{ number_format(\App\Models\Testimonials::where('status', 'pending')->count()) }}</div>
                    <div class="text-base mt-2">Pending Admin</div>
                </div>
            @endif
        </div>

        <div id="testimoni-grid">
            @if($testimonials->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($testimonials as $t)
                        <div id="testimoni-{{ $t->id }}"
                            class="group bg-white rounded-3xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 hover:border-green-100 overflow-hidden flex flex-col">

                            @if($t->foto)
                                <div class="aspect-square overflow-hidden bg-gray-50">
                                    <img src="{{ Storage::url($t->foto) }}" alt="{{ $t->nama }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                                </div>
                            @else
                                <div
                                    class="aspect-square bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 flex items-center justify-center">
                                    <div
                                        class="w-24 h-24 rounded-2xl bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center text-4xl font-black text-white shadow-md select-none">
                                        {{ strtoupper(substr($t->nama, 0, 1)) }}
                                    </div>
                                </div>
                            @endif

                            <div class="px-5 pt-4 pb-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-bold text-gray-900 text-base leading-tight truncate">
                                            {{ $t->nama }}
                                        </h3>
                                        <p class="text-xs text-gray-400 mt-0.5 truncate">
                                            {{ $t->jurusan ?? 'Alumni' }}
                                            @if($t->pekerjaan) · {{ $t->pekerjaan }} @endif
                                            @if($t->perusahaan)
                                                <span class="text-green-600 font-medium">@ {{ $t->perusahaan }}</span>
                                            @endif
                                        </p>
                                        @if($t->tahun_lulus)
                                            <span
                                                class="inline-flex items-center gap-1 mt-2 text-xs font-semibold bg-green-50 text-green-700 border border-green-100 px-2.5 py-0.5 rounded-full">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 14l9-5-9-5-9 5 9 5z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 14l6.16-3.422A12.083 12.083 0 0121 21H3a12.083 12.083 0 012.84-10.422L12 14z" />
                                                </svg>
                                                Lulus {{ $t->tahun_lulus }}
                                            </span>
                                        @endif
                                    </div>
                                    @auth
                                        @if(auth()->id() === $t->user_id || auth()->user()->role === 'admin')
                                            <a href="{{ route('testimoni.edit', $t) }}"
                                                class="shrink-0 self-start text-xs font-semibold text-gray-400 hover:text-green-600 border border-gray-200 hover:border-green-300 px-2.5 py-1 rounded-lg transition">
                                                Edit
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            </div>

                            <div class="px-5 pt-4 pb-5 flex flex-col flex-1">
                                <div class="flex-1 bg-gray-50 rounded-2xl p-4 relative">
                                    <span
                                        class="absolute -top-3 left-4 text-green-300 text-4xl font-serif leading-none select-none">"</span>
                                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-4 break-words pt-2">
                                        {{ $t->isi_testimoni }}
                                    </p>
                                </div>
                                <div class="flex items-center justify-end mt-3">
                                    <span class="text-xs text-gray-300">{{ $t->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $testimonials->appends(request()->query())->links() }}
                </div>

            @else
                <div class="text-center py-20">
                    <div
                        class="w-32 h-32 mx-auto mb-8 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center">
                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">Belum ada testimoni</h3>
                    <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">Jadilah yang pertama membagikan pengalaman suksesmu!
                    </p>
                    @auth
                        <a href="{{ route('testimoni.create') }}"
                            class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold px-12 py-4 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 text-lg">
                            + Bagikan Testimoni Pertama
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-white border-2 border-green-600 text-green-600 font-semibold px-12 py-4 rounded-2xl shadow-lg hover:bg-green-600 hover:text-white transition text-lg">
                            Login untuk Berbagi
                        </a>
                    @endauth
                </div>
            @endif
        </div>

    </section>
@endsection