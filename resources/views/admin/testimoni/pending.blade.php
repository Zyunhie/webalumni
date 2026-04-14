@extends('layouts.app')

@section('title', 'Testimoni Pending')

@section('content')
<div class="p-8 max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Testimoni Menunggu Persetujuan</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:underline">← Dashboard</a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- FIX: variabel $pending sesuai yang di-pass controller --}}
    @if($pending->count() > 0)
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jurusan / Tahun</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pekerjaan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Isi Testimoni</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pengirim</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pending as $item)
                        <tr class="hover:bg-gray-50">
                            {{-- Nama + foto --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full overflow-hidden bg-green-100 flex-shrink-0">
                                        @if($item->foto)
                                            <img src="{{ Storage::url($item->foto) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-green-600 font-bold text-lg">
                                                {{ strtoupper(substr($item->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="font-semibold text-gray-900">{{ $item->nama }}</div>
                                </div>
                            </td>

                            {{-- FIX: kolom jurusan + tahun_lulus (bukan angkatan) --}}
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div>{{ $item->jurusan ?? '-' }}</div>
                                <div class="text-gray-400">{{ $item->tahun_lulus ?? '-' }}</div>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $item->pekerjaan ?? '-' }}
                                @if($item->perusahaan)
                                    <div class="text-xs text-gray-400">{{ $item->perusahaan }}</div>
                                @endif
                            </td>

                            {{-- FIX: kolom isi_testimoni (bukan pesan) --}}
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs">
                                {{ Str::limit($item->isi_testimoni, 120) }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ $item->user->name ?? 'User' }}
                                </span>
                                <div class="text-xs text-gray-400 mt-1">{{ $item->created_at->diffForHumans() }}</div>
                            </td>

                            {{-- Aksi: Approve + Reject dengan alasan --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex flex-col gap-2">
                                    {{-- FIX: route name admin.testimoni.approve --}}
                                    <form action="{{ route('admin.testimoni.approve', $item) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded text-xs font-semibold transition">
                                            ✓ Setujui
                                        </button>
                                    </form>

                                    {{-- FIX: Reject pakai modal kecil inline supaya bisa isi alasan --}}
                                    <button type="button"
                                        onclick="document.getElementById('reject-modal-{{ $item->id }}').classList.remove('hidden')"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-1.5 rounded text-xs font-semibold transition">
                                        ✕ Tolak
                                    </button>
                                </div>

                                {{-- Modal reject inline --}}
                                <div id="reject-modal-{{ $item->id }}"
                                    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
                                        <h3 class="text-lg font-bold text-gray-800 mb-1">Tolak Testimoni</h3>
                                        <p class="text-sm text-gray-500 mb-4">Testimoni dari <strong>{{ $item->nama }}</strong></p>

                                        {{-- FIX: route name admin.testimoni.reject + field alasan_penolakan --}}
                                        <form action="{{ route('admin.testimoni.reject', $item) }}" method="POST">
                                            @csrf
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Alasan penolakan <span class="text-red-500">*</span>
                                            </label>
                                            <textarea name="alasan_penolakan" rows="3" required
                                                placeholder="Jelaskan alasan penolakan ke pengirim..."
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-200 focus:border-red-400 resize-none mb-4"></textarea>

                                            <div class="flex gap-3">
                                                <button type="button"
                                                    onclick="document.getElementById('reject-modal-{{ $item->id }}').classList.add('hidden')"
                                                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold px-4 py-2 rounded-lg text-sm transition">
                                                    Batal
                                                </button>
                                                <button type="submit"
                                                    class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
                                                    Tolak Testimoni
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-lg shadow-lg">
            <svg class="w-20 h-20 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Tidak ada testimoni pending</h3>
            <p class="text-gray-600">Semua testimoni sudah diproses.</p>
        </div>
    @endif
</div>
@endsection