@extends('layouts.app')

@section('title', 'Testimoni Pending')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 sm:px-6 lg:px-8">
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Testimoni Pending Approval
            </h2>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            <div class="flex items-center">
                <span class="ml-2 text-sm text-gray-500">{{ $pending->total() }} testimoni menunggu</span>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($pending->count())
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg bg-white">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preview</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengirim</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Testimoni</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pending as $t)
                    <tr class="hover:bg-gray-50">
                        <!-- Preview Foto -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($t->foto)
                                <img src="{{ Storage::url($t->foto) }}" alt="Preview" class="w-20 h-20 rounded-lg object-cover">
                            @else
                                <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                    <span class="text-lg">👤</span>
                                </div>
                            @endif
                        </td>

                        <!-- Pengirim -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $t->user->name ?? 'User #' . $t->user_id }}</div>
                            <div class="text-sm text-gray-500">{{ $t->user->email ?? '-' }}</div>
                            <div class="text-xs text-gray-400 mt-1">ID: {{ $t->id }}</div>
                        </td>

                        <!-- Detail -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $t->nama }}</div>
                            <div class="text-sm text-gray-500">{{ $t->jurusan }} • {{ $t->tahun_lulus }}</div>
                            <div class="text-sm text-gray-500">{{ $t->pekerjaan }} @ {{ $t->perusahaan ?? 'Freelance' }}</div>
                        </td>

                        <!-- Testimoni Preview -->
                        <td class="px-6 py-4 max-w-md">
                            <p class="text-sm text-gray-900 line-clamp-3">{{ $t->isi_testimoni }}</p>
                        </td>

                        <!-- Aksi -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <!-- Detail Modal Trigger -->
                            <button onclick="openDetail({{ $t->id }})" class="text-indigo-600 hover:text-indigo-900">
                                Detail
                            </button>

                            <!-- Approve -->
                            <form action="{{ route('admin.testimonials.approve', $t) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-100 hover:bg-green-200 text-green-800 px-4 py-2 rounded-lg font-semibold transition">
                                    <i class="fas fa-check mr-1"></i> Setujui
                                </button>
                            </form>

                            <!-- Reject with Reason -->
                            <button onclick="openReject({{ $t->id }})" class="bg-red-100 hover:bg-red-200 text-red-800 px-4 py-2 rounded-lg font-semibold transition">
                                <i class="fas fa-times mr-1"></i> Tolak
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $pending->appends(request()->query())->links() }}
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada testimoni pending</h3>
            <p class="mt-1 text-sm text-gray-500">Semua testimoni sudah diproses.</p>
        </div>
    @endif
</div>

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50" style="display: none;">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-bold text-gray-900 mb-4" id="detailTitle">Detail Testimoni</h3>
            <div id="detailContent" class="text-sm text-gray-700 space-y-3"></div>
        </div>
        <div class="items-center px-4 py-3">
            <button onclick="closeDetail()" class="px-4 py-2 bg-gray-500 text-white text-base font-semibold rounded-md shadow-sm hover:bg-gray-600 w-full">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50" style="display: none;">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-bold text-gray-900 mb-4" id="rejectTitle">Tolak Testimoni</h3>
            <form id="rejectForm" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="testimonial_id" id="rejectId">
                <textarea name="alasan" required rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan alasan penolakan (max 500 karakter)..."></textarea>
                <p class="text-xs text-gray-500">Alasan ini akan ditampilkan ke pengirim</p>
            </form>
        </div>
        <div class="items-center px-4 py-3 space-x-3">
            <button onclick="closeReject()" class="px-4 py-2 bg-gray-500 text-white text-base font-semibold rounded-md shadow-sm hover:bg-gray-600">
                Batal
            </button>
            <button onclick="submitReject()" class="px-4 py-2 bg-red-600 text-white text-base font-semibold rounded-md shadow-sm hover:bg-red-700">
                Tolak Testimoni
            </button>
        </div>
    </div>
</div>

<script>
let currentTestimonialId = null;

function openDetail(id) {
    fetch(`/testimonials/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detailTitle').innerText = `Testimoni - ${data.nama}`;
            document.getElementById('detailContent').innerHTML = `
                <div class="space-y-3">
                    <div><strong>Jurusan:</strong> ${data.jurusan}</div>
                    <div><strong>Tahun Lulus:</strong> ${data.tahun_lulus}</div>
                    <div><strong>Pekerjaan:</strong> ${data.pekerjaan || '-'}</div>
                    <div><strong>Perusahaan:</strong> ${data.perusahaan || '-'}</div>
                    <div><strong>Testimoni:</strong></div>
                    <div class="bg-gray-50 p-4 rounded-lg">${data.isi_testimoni}</div>
                </div>
            `;
            document.getElementById('detailModal').style.display = 'block';
        });
}

function closeDetail() {
    document.getElementById('detailModal').style.display = 'none';
}

function openReject(id) {
    currentTestimonialId = id;
    document.getElementById('rejectId').value = id;
    document.getElementById('rejectTitle').innerText = 'Tolak Testimoni #' + id;
    document.getElementById('rejectModal').style.display = 'block';
}

function closeReject() {
    document.getElementById('rejectModal').style.display = 'none';
}

function submitReject() {
    const form = document.getElementById('rejectForm');
    const formData = new FormData(form);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'POST');

    fetch(`/admin/testimonials/${currentTestimonialId}/reject`, {
        method: 'POST',
        body: formData
    }).then(response => {
        if (response.ok) {
            location.reload();
        } else {
            alert('Error saat menolak testimoni');
        }
    });
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeDetail();
        closeReject();
    }
});
</script>
@endsection
