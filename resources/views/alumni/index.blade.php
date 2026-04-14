@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Alumni</h1>
@auth
            <a href="{{ route('alumni.data') }}" class="bg-gray-500 hover:bg-gray-400 text-white px-4 py-2 rounded-lg text-sm">
                ← Kembali
            </a>
        @endauth
    </div>

    @auth
    @if(auth()->user()->role == 'admin')
        <div class="bg-white p-4 rounded-lg shadow mb-6 flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-xs font-semibold mb-1">Import Excel/CSV</label>
                <form action="{{ route('admin.alumni.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" accept=".csv,.txt" required>
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Import</button>
                </form>
            </div>
            <div>
                <a href="{{ route('admin.alumni.template') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg text-sm inline-block">Download Template CSV</a>
            </div>
        </div>
    @endif
    @endauth

    {{-- Filter --}}
<form method="GET" action="{{ route($routePrefix . '.index') }}" class="mb-6 flex flex-wrap gap-3 bg-white p-4 rounded-lg shadow items-end">
    <div>
        <label class="block text-xs font-semibold mb-1">Angkatan</label>
        <select name="angkatan" class="border rounded px-3 py-2 text-sm w-32">
            <option value="">Semua</option>
            @foreach($angkatanList as $tahun)
                <option value="{{ $tahun }}" {{ request('angkatan') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
            @endforeach
        </select>
    </div>

    @auth
    @if(auth()->user()->role == 'admin')
    <div>
        <label class="block text-xs font-semibold mb-1">Mode</label>
        <button type="button" id="modeToggle" class="relative inline-flex items-center h-8 rounded-full w-14 transition-colors focus:outline-none 
            {{ request('mode') == 'pending' ? 'bg-yellow-500' : 'bg-gray-300' }}" onclick="toggleMode()">
            <span class="sr-only">Toggle mode</span>
            <span class="inline-block w-6 h-6 transform transition-transform bg-white rounded-full shadow 
                {{ request('mode') == 'pending' ? 'translate-x-7' : 'translate-x-1' }}"></span>
            <span class="absolute left-1 text-xs font-medium {{ request('mode') == 'pending' ? 'text-white opacity-100' : 'text-gray-600 opacity-0' }}">Request</span>
            <span class="absolute right-1 text-xs font-medium {{ request('mode') == 'pending' ? 'text-gray-600 opacity-0' : 'text-white opacity-100' }}">Normal</span>
        </button>
        <input type="hidden" name="mode" id="modeInput" value="{{ request('mode') }}">
    </div>
    @endif
    @endauth

    <div class="flex items-end gap-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
        <a href="{{ route($routePrefix . '.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg text-sm">Reset</a>
    </div>
</form>

    {{-- Tabel Alumni --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIM</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prodi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Angkatan</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($alumni as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $item->nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $item->nim ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{-- Kolom Prodi menjadi link filter --}}
                        <a href="{{ route($routePrefix . '.index', array_merge(request()->except('prodi'), ['prodi' => $item->prodi])) }}" 
                           class="text-blue-600 hover:underline">
                            {{ $item->prodi }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $item->angkatan ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-center space-x-2">
                        @auth
                            <a href="{{ route($routePrefix . '.show', $item->id) }}" class="text-blue-600 hover:underline">Detail</a>

                            @if(auth()->user()->role == 'admin')
                                <a href="{{ route($routePrefix . '.edit', $item->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                                <form action="{{ route($routePrefix . '.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                                </form>
                            @elseif($item->user_id == auth()->id())
                                <a href="{{ route($routePrefix . '.edit', $item->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                                @if(!$item->ijazah || !$item->transkrip)
                                    <a href="{{ route($routePrefix . '.upload', $item->id) }}" class="text-green-600 hover:underline">Upload</a>
                                @endif
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        @else
                            @if($item->status == 'approved')
                                <a href="{{ route($routePrefix . '.show', $item->id) }}" class="text-blue-600 hover:underline">Detail</a>
                            @else
                                <span class="text-gray-400">Tidak tersedia</span>
                            @endif
                        @endauth
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data alumni.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $alumni->appends(request()->query())->links() }}
    </div>
</section>

<script>
    function toggleMode() {
        const toggleBtn = document.getElementById('modeToggle');
        const modeInput = document.getElementById('modeInput');
        const currentMode = modeInput.value;
        const newMode = currentMode === 'pending' ? '' : 'pending';
        
        // Visual feedback
        toggleBtn.classList.toggle('bg-yellow-500', newMode === 'pending');
        toggleBtn.classList.toggle('bg-gray-300', newMode !== 'pending');
        const slider = toggleBtn.querySelector('span:nth-child(2)');
        slider.classList.toggle('translate-x-7', newMode === 'pending');
        slider.classList.toggle('translate-x-1', newMode !== 'pending');
        
        // Build URL
        const url = new URL('{{ route($routePrefix . ".index") }}', window.location.origin);
        if (newMode) {
            url.searchParams.set('mode', newMode);
        }
        const otherParams = new URLSearchParams(window.location.search);
        otherParams.forEach((value, key) => {
            if (key !== 'mode') url.searchParams.set(key, value);
        });
        
        fetch(url.toString())
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const tableContainer = document.querySelector('.overflow-x-auto');
                const table = doc.querySelector('.overflow-x-auto table');
                if (table) {
                    tableContainer.innerHTML = table.parentElement.innerHTML;
                }
                const pagination = document.querySelector('.mt-6');
                const newPagination = doc.querySelector('.mt-6');
                if (newPagination && pagination) {
                    pagination.innerHTML = newPagination.innerHTML;
                }
                modeInput.value = newMode;
            })
            .catch(error => {
                console.error('Toggle failed:', error);
                location.reload(); // Fallback
            });
    }
</script>
@endsection