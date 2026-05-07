@extends('layouts.app')

@section('title', 'Review Testimoni')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-green-700 font-semibold">Kembali ke dashboard</a>
            <h1 class="text-3xl font-bold text-gray-900 mt-3">Review Testimoni</h1>
            <p class="text-gray-500 mt-2">Kelola antrean testimoni alumni tanpa kehilangan riwayat revisi.</p>
        </div>
        <a href="{{ route('testimoni.index') }}" class="inline-flex justify-center bg-gray-900 hover:bg-gray-800 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition">
            Lihat Halaman Publik
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl mb-6 text-sm">
            {{ session('info') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm space-y-1">
            @foreach($errors->all() as $error)
                <div>- {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @foreach([
            'pending' => ['label' => 'Menunggu Review', 'count' => $stats['pending']],
            'approved' => ['label' => 'Dipublikasikan', 'count' => $stats['approved']],
            'rejected' => ['label' => 'Perlu Revisi', 'count' => $stats['rejected']],
        ] as $key => $item)
            <a href="{{ route('admin.testimoni.pending', ['status' => $key]) }}"
                class="rounded-xl border p-5 transition {{ $status === $key ? 'bg-green-600 border-green-600 text-white shadow-sm' : 'bg-white border-gray-100 text-gray-700 hover:border-green-200' }}">
                <div class="text-2xl font-bold">{{ number_format($item['count']) }}</div>
                <div class="text-sm mt-1 {{ $status === $key ? 'text-white/80' : 'text-gray-500' }}">{{ $item['label'] }}</div>
            </a>
        @endforeach
    </div>

    <form method="GET" class="bg-white border border-gray-100 rounded-xl p-4 mb-6">
        <input type="hidden" name="status" value="{{ $status }}">
        <div class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, prodi, pekerjaan, perusahaan, atau isi testimoni..."
                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-green-200 focus:border-green-400 outline-none">
            <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.testimoni.pending', ['status' => $status]) }}" class="border border-gray-200 hover:bg-gray-50 text-gray-600 px-5 py-2.5 rounded-lg font-semibold text-sm text-center transition">Reset</a>
            @endif
        </div>
    </form>

    @if($testimonials->count() > 0)
        <div class="space-y-4">
            @foreach($testimonials as $item)
                <article class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-5 grid grid-cols-1 lg:grid-cols-[260px_1fr_220px] gap-5">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-full overflow-hidden bg-green-50 flex items-center justify-center shrink-0">
                                @if($item->foto)
                                    <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-green-700 font-bold text-xl">{{ strtoupper(substr($item->nama, 0, 1)) }}</span>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <h2 class="font-bold text-gray-900 truncate">{{ $item->nama }}</h2>
                                <p class="text-xs text-gray-500 mt-1">{{ $item->jurusan ?? '-' }}{{ $item->tahun_lulus ? ' - '.$item->tahun_lulus : '' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $item->user->name ?? 'User' }} - {{ $item->created_at->diffForHumans() }}</p>
                                <span class="inline-flex mt-3 px-2.5 py-1 rounded-full border text-xs font-semibold {{ $item->status_badge_class }}">
                                    {{ $item->status_label }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <div class="flex flex-wrap gap-2 mb-3">
                                @if($item->pekerjaan)
                                    <span class="px-2.5 py-1 bg-gray-50 border border-gray-100 rounded-full text-xs text-gray-600">{{ $item->pekerjaan }}</span>
                                @endif
                                @if($item->perusahaan)
                                    <span class="px-2.5 py-1 bg-gray-50 border border-gray-100 rounded-full text-xs text-gray-600">{{ $item->perusahaan }}</span>
                                @endif
                                @if($item->approver)
                                    <span class="px-2.5 py-1 bg-blue-50 border border-blue-100 rounded-full text-xs text-blue-700">Reviewer: {{ $item->approver->name }}</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $item->isi_testimoni }}</p>
                            @if($item->alasan_penolakan)
                                <div class="mt-4 bg-red-50 border border-red-100 rounded-lg p-3 text-sm text-red-700">
                                    <div class="font-bold mb-1">Alasan penolakan</div>
                                    <div>{{ $item->alasan_penolakan }}</div>
                                </div>
                            @endif
                        </div>

                        <div class="flex lg:flex-col gap-2">
                            @if($item->status !== 'approved')
                                <form action="{{ route('admin.testimoni.approve', $item) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                        Setujui
                                    </button>
                                </form>
                            @endif

                            @if($item->status !== 'rejected')
                                <button type="button"
                                    onclick="document.getElementById('reject-modal-{{ $item->id }}').classList.remove('hidden')"
                                    class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                    Tolak
                                </button>
                            @endif

                            <form action="{{ route('testimoni.destroy', $item) }}" method="POST" class="flex-1"
                                onsubmit="return confirm('Hapus testimoni ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full border border-red-200 hover:bg-red-50 text-red-700 px-4 py-2 rounded-lg text-sm font-semibold transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </article>

                <div id="reject-modal-{{ $item->id }}" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900">Tolak Testimoni</h3>
                        <p class="text-sm text-gray-500 mt-1 mb-4">Alasan ini akan tampil ke alumni agar bisa direvisi.</p>
                        <form action="{{ route('admin.testimoni.reject', $item) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Alasan penolakan <span class="text-red-500">*</span></label>
                                <textarea name="alasan_penolakan" rows="4" required minlength="10" maxlength="1000"
                                    placeholder="Contoh: Mohon perjelas dampak pengalaman kuliah dan gunakan foto yang lebih formal."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-200 focus:border-red-400 resize-y">{{ old('alasan_penolakan') }}</textarea>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="document.getElementById('reject-modal-{{ $item->id }}').classList.add('hidden')"
                                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold px-4 py-2.5 rounded-lg text-sm transition">
                                    Batal
                                </button>
                                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2.5 rounded-lg text-sm transition">
                                    Tolak dan Kirim Alasan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $testimonials->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white border border-gray-100 rounded-xl">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak ada testimoni di status ini</h3>
            <p class="text-gray-500">Coba status lain atau ubah kata kunci pencarian.</p>
        </div>
    @endif
</div>
@endsection
