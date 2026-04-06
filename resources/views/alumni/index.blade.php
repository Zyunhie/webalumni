@extends('layouts.app')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Daftar Alumni</h1>

    @if(request('prodi'))
        <p class="text-center text-gray-600 mb-4">Menampilkan alumni prodi: <strong>{{ request('prodi') }}</strong></p>
    @endif

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($alumni as $item)
            <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition">
                @if($item->foto)
                    <img src="{{ $item->foto_url }}" alt="foto" class="w-24 h-24 object-cover rounded-full mx-auto mb-3">
                @else
                    <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-3 flex items-center justify-center text-gray-500">No Foto</div>
                @endif
                <h2 class="text-xl font-semibold text-center">{{ $item->nama }}</h2>
                <p class="text-gray-600 text-center">{{ $item->prodi }} - {{ $item->angkatan }}</p>
                <p class="text-gray-600 text-center">{{ $item->pekerjaan ?? 'Belum bekerja' }}</p>
                <div class="mt-4 text-center">
                    <a href="{{ route('alumni.show', $item->id) }}" class="bg-green-600 text-white px-4 py-2 rounded-full text-sm hover:bg-green-700">Lihat Detail</a>
                </div>
            </div>
        @empty
            <p class="col-span-3 text-center text-gray-500">Belum ada alumni yang disetujui.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $alumni->links() }}
    </div>
</section>
@endsection