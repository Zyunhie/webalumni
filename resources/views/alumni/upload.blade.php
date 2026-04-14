@extends('layouts.app')

@section('content')
<section class="max-w-2xl mx-auto px-6 py-10">
    <div class="bg-white rounded-xl shadow-md p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Upload Dokumen</h1>
        <p class="text-gray-600 mb-6">Untuk alumni: <strong>{{ $alumni->nama }}</strong> ({{ $alumni->nim }})</p>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route($routePrefix . '.upload.store', $alumni->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold mb-1">Ijazah</label>
                @if($alumni->ijazah)
                    <div class="mb-2 text-sm">
                        <span class="text-gray-600">File saat ini:</span>
                        <a href="{{ $alumni->ijazah_url }}" target="_blank" class="text-blue-600 underline ml-2">Lihat Ijazah</a>
                    </div>
                @endif
                <input type="file" name="ijazah" accept=".pdf,.jpg,.jpeg,.png" class="w-full border-gray-300 rounded-lg">
                <p class="text-xs text-gray-500 mt-1">PDF, JPG, JPEG, PNG. Maks 5MB.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Transkrip Nilai</label>
                @if($alumni->transkrip)
                    <div class="mb-2 text-sm">
                        <span class="text-gray-600">File saat ini:</span>
                        <a href="{{ $alumni->transkrip_url }}" target="_blank" class="text-blue-600 underline ml-2">Lihat Transkrip</a>
                    </div>
                @endif
                <input type="file" name="transkrip" accept=".pdf,.jpg,.jpeg,.png" class="w-full border-gray-300 rounded-lg">
                <p class="text-xs text-gray-500 mt-1">PDF, JPG, JPEG, PNG. Maks 5MB.</p>
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route($routePrefix . '.show', $alumni->id) }}" class="text-gray-500 hover:underline">← Kembali ke Detail</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-full shadow">
                    Upload Dokumen
                </button>
            </div>
        </form>
    </div>
</section>
@endsection