@extends('layouts.app')

@section('title', 'Lowongan Saya')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Lowongan Saya</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar lowongan yang telah kamu ajukan.</p>
        </div>
        <a href="{{ route('alumni.lowongan.create') }}"
           class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-full hover:bg-green-700 transition">
            + Ajukan Lowongan
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Judul</th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Perusahaan</th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                    <th class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($lowongans as $lowongan)
                    <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                            {{ $lowongan->judul }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ $lowongan->perusahaan }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                            @if($lowongan->status === 'approved')
                                <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">✓ Disetujui</span>
                            @elseif($lowongan->status === 'rejected')
                                <span class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800"
                                      @if($lowongan->rejection_reason) title="{{ $lowongan->rejection_reason }}" @endif>
                                    ✗ Ditolak @if($lowongan->rejection_reason)(hover untuk alasan)@endif
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">⏳ Menunggu Review</span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ $lowongan->created_at->format('d M Y') }}
                        </td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <a href="{{ route('lowongan.show', $lowongan) }}"
                               class="text-green-600 hover:text-green-900 mr-3">Lihat</a>
                            <a href="{{ route('alumni.lowongan.edit', $lowongan) }}"
                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">
                            Belum ada lowongan yang diajukan.
                            <a href="{{ route('alumni.lowongan.create') }}" class="text-green-600 hover:underline ml-1">Ajukan sekarang →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $lowongans->links() }}
    </div>
</div>
@endsection