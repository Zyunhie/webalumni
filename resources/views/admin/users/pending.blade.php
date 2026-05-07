@extends('layouts.app')

@section('content')
<section class="relative h-[400px] bg-cover bg-center"
    style="background-image: url('{{ isset($heroVerif) && $heroVerif ? Storage::url($heroVerif->gambar) : asset('images/Branda.jpg') }}');">
    @if(auth()->check() && auth()->user()->role === 'admin')
        <a href="{{ route('admin.hero.index') }}"
            class="absolute bottom-4 right-4 z-10 bg-white bg-opacity-90 hover:bg-opacity-100 text-green-700 font-semibold text-xs px-4 py-2 rounded-full shadow-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Kelola Slider
        </a>
    @endif
</section>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Verifikasi Akun Alumni</h1>
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">{{ session('error') }}</div>
    @endif
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Data</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama/NIM</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prodi/Angkatan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Daftar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingUsers as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        @if($user->is_data_matched)
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">✓ Data Cocok (Import)</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">⚠ Registrasi Manual</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium">{{ $user->name }}</div>
                        <div class="text-sm text-gray-500">NIM: {{ $user->nim }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div>{{ $user->prodi }}</div>
                        <div class="text-sm text-gray-500">Angkatan: {{ $user->angkatan }}</div>
                    </td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <form action="{{ route('admin.users.approve', $user) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                Setujui
                            </button>
                        </form>
                        <button onclick="showRejectModal({{ $user->id }})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                            Tolak
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        Tidak ada user yang menunggu verifikasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $pendingUsers->links() }}
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
    <div class="relative top-20 mx-auto p-5 w-96 bg-white rounded-lg">
        <h3 class="text-lg font-medium mb-4">Tolak Pendaftaran</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <textarea name="reason" required rows="4" class="w-full border rounded p-2" placeholder="Alasan penolakan..."></textarea>
            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Tolak</button>
            </div>
        </form>
    </div>
</div>

<script>
function showRejectModal(userId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/admin/users/${userId}/reject`;
    modal.classList.remove('hidden');
}

function closeModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection