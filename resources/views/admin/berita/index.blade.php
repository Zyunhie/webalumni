@extends('layouts.app')

@section('content')

<!-- ================= HERO SECTION ================= -->
<section
    class="relative h-[400px] flex items-center justify-center text-center text-white bg-cover bg-center"
    style="background-image: url('{{ asset('images/Branda.jpg') }}');"
>
</section>

<div class="max-w-6xl mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Kelola Beritas</h1>
        <a href="{{ route('admin.berita.create') }}" 
           class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all">
            <i class="bi bi-plus-lg me-2"></i>Tambah Berita
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($berita->count() > 0)
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Gambar</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($berita as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-16 h-16 object-cover rounded-lg shadow">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="bi bi-image text-gray-500 text-xl"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 truncate max-w-xs">{{ $item->judul }}</div>
                                    <div class="text-sm text-gray-500 mt-1">{{ Str::limit($item->isi, 80) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.berita.edit', $item->id) }}" 
                                       class="text-indigo-600 hover:text-indigo-900">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.berita.destroy', $item->id) }}" class="inline" onsubmit="return confirm('Yakin hapus berita ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($berita->hasPages())
            <div class="mt-8">
                {{ $berita->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-20">
            <i class="bi bi-newspaper text-6xl text-gray-300 mb-6 block"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada berita</h3>
            <p class="text-gray-500 mb-8">Mulai tambah berita pertama Anda.</p>
        </div>
    @endif
</div>
@endsection
