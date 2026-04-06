@extends('layouts.app')

@section('title', 'Testimoni Saya')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-12">
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Testimoni Saya</h1>
        <p class="text-xl text-gray-600">Kelola testimoni yang Anda buat</p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-8 p-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-8 p-4">
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
        <a href="{{ route('testimonials.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 flex-1 text-center">
            + Tambah Testimoni Baru
        </a>
        <a href="{{ route('testimonials.index') }}" class="bg-white border-2 border-gray-200 hover:border-green-500 text-gray-800 font-semibold px-8 py-4 rounded-xl hover:bg-green-50 transition flex-1 text-center">
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
                                    <a href="{{ route('testimonials.edit', $t) }}" class="text-green-600 hover:text-green-900 font-semibold">
                                        Edit
                                    </a>
                                @endif
                                @if($t->status !== 'approved')
                                    <form action="{{ route('testimonials.destroy', $t) }}" method="POST" class="inline" onsubmit="return confirm('Hapus testimoni ini?')">
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
            </div>
        @else
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada testimoni</h3>
                <p class="text-gray-600 mb-8">Mulai bagikan pengalaman Anda dengan menambah testimoni baru</p>
                <a href="{{ route('testimonials.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold px-12 py-4 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                    + Tambah Testimoni Pertama
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
