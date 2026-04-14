@extends('layouts.app')

@section('title', 'Kelola Pesan Kontak')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold text-gray-900">Pesan Masuk</h1>
            <p class="mt-2 text-sm text-gray-600">Daftar pesan dari pengunjung website.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <form action="{{ route('admin.kontak.markAllRead') }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                    Tandai Semua Dibaca
                </button>
            </form>
        </div>
    </div>

    {{-- Filter --}}
    <div class="mt-6 bg-white p-4 rounded-lg shadow">
        <form method="GET" action="{{ route('admin.kontak.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                    <option value="">Semua</option>
                    <option value="belum_dibaca" {{ request('status') == 'belum_dibaca' ? 'selected' : '' }}>Belum Dibaca</option>
                    <option value="dibaca" {{ request('status') == 'dibaca' ? 'selected' : '' }}>Sudah Dibaca</option>
                </select>
            </div>
            <div class="md:col-span-4 flex justify-end space-x-2">
                <a href="{{ route('admin.kontak.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Reset</a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700">Filter</button>
            </div>
        </form>
    </div>

    {{-- Tabel Pesan --}}
    <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Pengirim</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Pesan</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($pesans as $pesan)
                                <tr class="{{ $pesan->status == 'belum_dibaca' ? 'bg-yellow-50' : '' }}">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        {{ $pesan->nama }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $pesan->email }}</td>
                                    <td class="px-3 py-4 text-sm text-gray-500 max-w-xs truncate">{{ Str::limit($pesan->pesan, 50) }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $pesan->created_at->format('d M Y H:i') }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        @if($pesan->status == 'belum_dibaca')
                                            <span class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">Belum Dibaca</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Dibaca</span>
                                        @endif
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <button onclick="showDetail({{ $pesan->id }})" class="text-green-600 hover:text-green-900 mr-3">Lihat</button>
                                        @if($pesan->status == 'belum_dibaca')
                                            <form action="{{ route('admin.kontak.read', $pesan) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-blue-600 hover:text-blue-900 mr-3">Tandai Dibaca</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.kontak.destroy', $pesan) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus pesan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-gray-500">Tidak ada pesan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        {{ $pesans->withQueryString()->links() }}
    </div>
</div>

{{-- Modal Detail Pesan --}}
<div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Detail Pesan</h3>
                        <div class="mt-4 space-y-2">
                            <p><strong>Dari:</strong> <span id="modalNama"></span> (<span id="modalEmail"></span>)</p>
                            <p><strong>Tanggal:</strong> <span id="modalTanggal"></span></p>
                            <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                            <div class="mt-4">
                                <p class="font-medium">Pesan:</p>
                                <div id="modalPesan" class="mt-2 p-3 bg-gray-50 rounded-md whitespace-pre-wrap"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const pesans = @json($pesans->keyBy('id'));

    function showDetail(id) {
        const pesan = pesans[id];
        if (pesan) {
            document.getElementById('modalNama').textContent = pesan.nama;
            document.getElementById('modalEmail').textContent = pesan.email;
            document.getElementById('modalTanggal').textContent = new Date(pesan.created_at).toLocaleString('id-ID');
            document.getElementById('modalStatus').textContent = pesan.status === 'belum_dibaca' ? 'Belum Dibaca' : 'Sudah Dibaca';
            document.getElementById('modalPesan').textContent = pesan.pesan;
            document.getElementById('detailModal').classList.remove('hidden');
        }
    }

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    window.addEventListener('click', function(e) {
        const modal = document.getElementById('detailModal');
        if (e.target === modal) {
            closeModal();
        }
    });
</script>
@endsection