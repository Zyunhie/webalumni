@extends('layouts.app')

@section('title', 'Testimoni Alumni')

@section('content')
<!-- Hero Section -->
<section class="relative h-[400px] flex items-center justify-center text-center text-white bg-cover bg-center"
    style="background-image: url('{{ asset('images/Branda.JPG') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-white">
        <h1 class="text-4xl font-bold mb-4">Testimoni Alumni</h1>
        <p class="text-xl mb-6">Cerita Sukses dan Pengalaman Alumni Kami</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#testimoni-grid" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-full font-semibold transition">
                Lihat Testimoni
            </a>
            @auth
            <a href="{{ route('testimoni.create') }}" class="border border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-green-600 transition">
                Tambah Testimoni
            </a>
            @else
            <a href="{{ route('login') }}" class="border border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-green-600 transition">
                Login untuk Tambah
            </a>
            @endauth
        </div>
    </div>
</section>

<!-- Search & Stats -->
<section class="max-w-6xl mx-auto px-6 py-12">
    <div class="text-center mb-12">
        <form method="GET" class="max-w-md mx-auto mb-8">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau testimoni..." 
                       class="w-full pl-12 pr-6 py-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-green-200 focus:border-green-500 text-lg">
                <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-8 rounded-2xl shadow-xl">
                <div class="text-3xl font-bold">{{ $testimonials->total() }}</div>
                <div class="text-lg mt-2">Testimoni Tersedia</div>
            </div>
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-8 rounded-2xl shadow-xl">
{{ number_format(\App\Models\Testimoni::approved()->count()) }}
                <div class="text-lg mt-2">Approved</div>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-8 rounded-2xl shadow-xl">
{{ number_format(\App\Models\Testimoni::where('status', 'pending')->count()) }}
                <div class="text-lg mt-2">Pending Admin</div>
            </div>
        </div>
    </div>

    <!-- Testimoni Grid -->
    <div id="testimoni-grid">
        @if($testimonials->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
@foreach($testimonials as $testimoni)
    <?php $t = $testimoni; ?>
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-green-200">
                    @if($t->foto)
                        <div class="h-64 bg-gradient-to-br from-green-50 to-blue-50 relative overflow-hidden">
                            <img src="{{ Storage::url($t->foto) }}" alt="{{ $t->nama }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
{{ $t->tahun_lulus ?? $t->angkatan ?? '' }}
                            </div>
                        </div>
                    @else
                        <div class="h-64 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <div class="text-6xl text-gray-400">👤</div>
                        </div>
                    @endif
                    
                    <div class="p-8">
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-blue-400 rounded-2xl flex items-center justify-center text-2xl font-bold text-white mr-4">
                                {{ substr($t->nama, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-xl text-gray-800">{{ $t->nama }}</h3>
{{ $t->jurusan ?? 'Alumni' }} • {{ $t->pekerjaan ?? 'Freelancer' }} @ {{ $t->perusahaan ?? '-' }}
                            </div>
                        </div>

{{ $t->pesan ?? $t->isi_testimoni }}

                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-5 h-5 fill-yellow-400 mr-1" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.355 4.225a.994.994 0 00-.948 0l-.812 1.22a2 2 0 00-.728 1.235H5.928A2 2 0 004.845 8.72l-1.07 3.292a2 2 0 00.364 1.118l2.8 2.034a2 2 0 001.175 0l2.8-2.034a2 2 0 00.364-1.118l-1.07-3.292a2 2 0 00-.728-1.235l.812-1.22a.994.994 0 000-.948z" clip-rule="evenodd"/>
                            </svg>
                            <svg class="w-5 h-5 fill-yellow-400 mr-1" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.355 4.225a.994.994 0 00-.948 0l-.812 1.22a2 2 0 00-.728 1.235H5.928A2 2 0 004.845 8.72l-1.07 3.292a2 2 0 00.364 1.118l2.8 2.034a2 2 0 001.175 0l2.8-2.034a2 2 0 00.364-1.118l-1.07-3.292a2 2 0 00-.728-1.235l.812-1.22a.994.994 0 000-.948z" clip-rule="evenodd"/>
                            </svg>
                            <svg class="w-5 h-5 fill-yellow-400 mr-1" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.355 4.225a.994.994 0 00-.948 0l-.812 1.22a2 2 0 00-.728 1.235H5.928A2 2 0 004.845 8.72l-1.07 3.292a2 2 0 00.364 1.118l2.8 2.034a2 2 0 001.175 0l2.8-2.034a2 2 0 00.364-1.118l-1.07-3.292a2 2 0 00-.728-1.235l.812-1.22a.994.994 0 000-.948z" clip-rule="evenodd"/>
                            </svg>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-4">Belum ada testimoni</h3>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">Jadilah yang pertama membagikan pengalaman suksesmu sebagai alumni kami!</p>
                @auth
                <a href="{{ route('testimoni.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold px-12 py-4 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 text-lg">
                    + Bagikan Testimoni Pertama
                </a>
                @else
                <a href="{{ route('login') }}" class="bg-white border-2 border-green-600 text-green-600 font-semibold px-12 py-4 rounded-2xl shadow-lg hover:bg-green-600 hover:text-white transition text-lg">
                    Login untuk Berbagi
                </a>
                @endauth
            </div>
        @endif
    </div>
</section>

@endsection
