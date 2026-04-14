@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-10">
    <div class="bg-white rounded-xl shadow-md p-8">
        <div class="flex justify-between items-start mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Alumni</h1>
            @auth
                @if(auth()->user()->role === 'admin' || auth()->id() == $alumni->user_id)
                    <div>
                        <a href="{{ route($routePrefix . '.edit', $alumni->id) }}" class="bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded-lg">Edit</a>
                        @if(auth()->id() == $alumni->user_id && (!$alumni->ijazah || !$alumni->transkrip))
                            <a href="{{ route($routePrefix . '.upload', $alumni->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg ml-2">Upload Dokumen</a>
                        @endif
                    </div>
                @endif
            @endauth
        </div>

        {{-- Notifikasi status untuk semua user --}}
        @if($alumni->status == 'pending')
        @elseif($alumni->status == 'rejected')
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                ❌ Perubahan data ditolak. Alasan: {{ $alumni->rejection_reason ?? 'Tidak ada alasan' }}
            </div>
        @endif

        {{-- Tombol Approve/Reject untuk admin (hanya jika status pending) --}}
        @auth
            @if(auth()->user()->role === 'admin' && $alumni->status === 'pending')
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div>
                            <p class="text-yellow-800 font-semibold">⏳ Data ini sedang menunggu persetujuan admin.</p>
                            @if($alumni->pending_data)
                                <p class="text-sm text-gray-600 mt-1">Ada perubahan yang diajukan oleh alumni.</p>
                            @endif
                        </div>
                        <div class="flex gap-3">
                            {{-- Form Approve --}}
                            <form action="{{ route('admin.alumni.approve', $alumni->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">✅ Approve</button>
                            </form>
                            
                            {{-- Tombol Reject (buka modal/form) --}}
                            <button onclick="showRejectForm()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow">❌ Reject</button>
                        </div>
                    </div>
                    
                    {{-- Form Reject (hidden) --}}
                    <div id="rejectForm" style="display: none; margin-top: 15px;">
                        <form action="{{ route('admin.alumni.reject', $alumni->id) }}" method="POST">
                            @csrf
                            <textarea name="reason" rows="2" class="w-full border rounded p-2" placeholder="Tulis alasan penolakan..." required></textarea>
                            <div class="mt-2 flex gap-2">
                                <button type="submit" class="bg-red-700 text-white px-3 py-1 rounded">Kirim Penolakan</button>
                                <button type="button" onclick="hideRejectForm()" class="bg-gray-400 text-white px-3 py-1 rounded">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endauth

        <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                @if($alumni->foto)
                    <img src="{{ $alumni->foto_url }}" alt="foto" class="w-full rounded-lg shadow">
                @else
                    <div class="bg-gray-200 h-48 flex items-center justify-center rounded-lg text-gray-500">Tidak ada foto</div>
                @endif
            </div>
            <div class="md:col-span-2 space-y-3">
                <p><span class="font-semibold">Nama Lengkap:</span> {{ $alumni->nama }}</p>
                <p><span class="font-semibold">NIM:</span> {{ $alumni->nim ?? '-' }}</p>
                <p><span class="font-semibold">Program Studi:</span> {{ $alumni->prodi }}</p>
                <p><span class="font-semibold">Angkatan:</span> {{ $alumni->angkatan ?? '-' }}</p>
                <p><span class="font-semibold">Tahun Lulus:</span> {{ $alumni->lulusan ?? '-' }}</p>
                <p><span class="font-semibold">Pekerjaan:</span> {{ $alumni->pekerjaan ?? '-' }}</p>
                <p><span class="font-semibold">Perusahaan:</span> {{ $alumni->perusahaan ?? '-' }}</p>
                <p><span class="font-semibold">Email:</span> {{ $alumni->email ?? '-' }}</p>
                <p><span class="font-semibold">No HP:</span> {{ $alumni->no_hp ?? '-' }}</p>
                <p><span class="font-semibold">Alamat:</span> {{ $alumni->alamat ?? '-' }}</p>

                @if($alumni->ijazah)
                    <p><span class="font-semibold">Ijazah:</span> <a href="{{ $alumni->ijazah_url }}" target="_blank" class="text-blue-600 underline">Lihat</a></p>
                @endif
                @if($alumni->transkrip)
                    <p><span class="font-semibold">Transkrip:</span> <a href="{{ $alumni->transkrip_url }}" target="_blank" class="text-blue-600 underline">Lihat</a></p>
                @endif

                @if($alumni->status != 'approved' && (auth()->user()->role === 'admin' || auth()->id() == $alumni->user_id))
                    <div class="bg-yellow-100 text-yellow-800 p-3 rounded mt-4">
                        Status: <strong>{{ ucfirst($alumni->status) }}</strong>. Data ini belum disetujui admin, sehingga tidak tampil di publik.
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route($routePrefix . '.index') }}" class="text-gray-500 hover:underline">← Kembali ke daftar alumni</a>
        </div>
    </div>
</section>

<script>
function showRejectForm() {
    document.getElementById('rejectForm').style.display = 'block';
}
function hideRejectForm() {
    document.getElementById('rejectForm').style.display = 'none';
}
</script>
@endsection