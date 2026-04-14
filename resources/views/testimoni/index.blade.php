@extends('layouts.app')

@section('title', 'Testimoni Alumni')

@section('content')
    <!-- Hero Section -->
    <section class="relative h-[400px] flex items-center justify-center text-center text-white bg-cover bg-center"
        style="background-image: url('{{ asset('images/Branda.JPG') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center text-white">
            <h1 class="text-4xl font-bold mb-4">Testimoni Alumni</h1>
            <p class="text-xl mb-6">Cerita Sukses dan Pengalaman Alumni Kami</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#testimoni-grid"
                    class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-full font-semibold transition">
                    Lihat Testimoni
                </a>
                @auth
                    <a href="{{ route('testimoni.create') }}"
                        class="border border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-green-600 transition">
                        Tambah Testimoni
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="border border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-green-600 transition">
                        Login untuk Tambah
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Search & Stats -->
    <section class="max-w-6xl mx-auto px-6 py-12">

        <!-- Search -->
        <form method="GET" class="max-w-md mx-auto mb-10">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama atau testimoni..."
                    class="w-full pl-12 pr-6 py-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-green-200 focus:border-green-500 text-base">
                <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </form>

        <!-- Stats -->
        {{-- FIX: div pembungkus text-3xl yang hilang di card kedua & ketiga --}}
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
                    <div class="text-3xl font-bold">{{ number_format(\App\Models\Testimonials::where('status', 'pending')->count()) }}</div>
                    <div class="text-base mt-2">Pending Admin</div>
                    <div class="text-xs mt-1 opacity-75">Klik untuk review →</div>
                </a>
            @else
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-8 rounded-2xl shadow-xl text-center">
                    <div class="text-3xl font-bold">{{ number_format(\App\Models\Testimonials::where('status', 'pending')->count()) }}</div>
                    <div class="text-base mt-2">Pending Admin</div>
                </div>
            @endif
        </div>

        <!-- Testimoni Grid -->
        <div id="testimoni-grid">
            @if($testimonials->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($testimonials as $t)
                        <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-green-200 flex flex-col">

                            {{-- Foto / Avatar Header --}}
                            @if($t->foto)
                                <div class="aspect-square relative overflow-hidden bg-gray-100">
                                    <img src="{{ Storage::url($t->foto) }}" alt="{{ $t->nama }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    {{-- Badge tahun lulus --}}
                                    <div class="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                                        {{ $t->tahun_lulus ?? '' }}
                                    </div>
                                    {{-- FIX: Tombol Edit — muncul hanya kalau punya testimoni ini atau admin --}}
                                    @auth
                                        @if(auth()->id() === $t->user_id || auth()->user()->role === 'admin')
                                            <a href="{{ route('testimoni.edit', $t) }}"
                                                class="absolute top-3 left-3 bg-white text-green-600 hover:bg-green-600 hover:text-white text-xs font-bold px-3 py-1 rounded-full shadow transition">
                                                Edit
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            @else
                                <div class="aspect-square bg-gradient-to-br from-green-50 to-blue-50 flex flex-col items-center justify-center relative">
                                    {{-- Inisial sebagai avatar --}}
                                    <div class="w-20 h-20 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center text-3xl font-bold text-white shadow-lg">
                                        {{ strtoupper(substr($t->nama, 0, 1)) }}
                                    </div>
                                    <div class="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                                        {{ $t->tahun_lulus ?? '' }}
                                    </div>
                                    {{-- FIX: Tombol Edit juga di no-foto state --}}
                                    @auth
                                        @if(auth()->id() === $t->user_id || auth()->user()->role === 'admin')
                                            <a href="{{ route('testimoni.edit', $t) }}"
                                                class="absolute top-3 left-3 bg-white text-green-600 hover:bg-green-600 hover:text-white text-xs font-bold px-3 py-1 rounded-full shadow transition">
                                                Edit
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            @endif

                            {{-- Card Body --}}
                            <div class="p-6 flex flex-col flex-1">

                                {{-- Info orang --}}
                                <div class="mb-3">
                                    <h3 class="font-bold text-lg text-gray-800 leading-tight">{{ $t->nama }}</h3>
                                    <p class="text-sm text-gray-500 mt-0.5">
                                        {{ $t->jurusan ?? 'Alumni' }}
                                        @if($t->pekerjaan)
                                            · {{ $t->pekerjaan }}
                                        @endif
                                        @if($t->perusahaan)
                                            <span class="text-green-600 font-medium">@ {{ $t->perusahaan }}</span>
                                        @endif
                                    </p>
                                </div>

                                {{-- Divider --}}
                                <hr class="border-gray-100 mb-3">

                                {{-- Isi testimoni — truncated, bisa expand --}}
                                <div class="flex-1">
                                    {{-- Tanda kutip dekoratif --}}
                                    <svg class="w-7 h-7 text-green-200 mb-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                    </svg>
                                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-4 break-words overflow-hidden">
                                        {{ $t->isi_testimoni }}
                                    </p>
                                </div>

                                {{-- Footer card: tanggal aja --}}
                                <div class="flex items-center justify-end mt-4 pt-3 border-t border-gray-100">
                                    <span class="text-xs text-gray-400">
                                        {{ $t->created_at->diffForHumans() }}
                                    </span>
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
                    <div class="w-32 h-32 mx-auto mb-8 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center">
                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">Belum ada testimoni</h3>
                    <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">Jadilah yang pertama membagikan pengalaman suksesmu sebagai alumni kami!</p>
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