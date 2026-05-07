<?php

namespace App\Http\Controllers;

use App\Models\Testimonials;
use App\Models\Alumni;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    // Halaman publik (testimoni yang sudah disetujui)
    public function index(Request $request)
    {
        $HeroTestimoni = HeroSlide::where('page', 'testimoni')->where('aktif', true)->first();

        $query = Testimonials::approved();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('jurusan', 'like', '%' . $request->search . '%')
                  ->orWhere('pekerjaan', 'like', '%' . $request->search . '%')
                  ->orWhere('perusahaan', 'like', '%' . $request->search . '%')
                  ->orWhere('isi_testimoni', 'like', '%' . $request->search . '%');
            });
        }

        $testimonials = $query->latest('approved_at')->latest()->paginate(12);
        $stats = [
            'approved' => Testimonials::approved()->count(),
            'pending' => Testimonials::pending()->count(),
            'rejected' => Testimonials::rejected()->count(),
        ];
        $myTestimonial = Auth::check()
            ? Testimonials::where('user_id', Auth::id())->latest()->first()
            : null;

        return view('testimoni.index', compact('HeroTestimoni', 'testimonials', 'stats', 'myTestimonial'));
    }

    // Form buat testimoni
    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.testimoni.pending')
                ->with('info', 'Admin hanya dapat mereview testimoni alumni.');
        }

        $existing = Testimonials::where('user_id', $user->id)->first();
        if ($existing) {
            return redirect()->route('testimoni.edit', $existing)
                ->with('info', 'Anda sudah memiliki testimoni. Silakan kelola atau revisi testimoni Anda di halaman ini.');
        }

        $alumni = Alumni::where('user_id', $user->id)
                        ->where('status', 'approved')
                        ->first();

        return view('testimoni.create', compact('alumni'));
    }

    // Simpan testimoni baru
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            abort(403, 'Admin tidak dapat mengirim testimoni.');
        }

        $existing = Testimonials::where('user_id', $user->id)->first();
        if ($existing) {
            return redirect()->route('testimoni.edit', $existing)
                ->with('info', 'Anda sudah memiliki testimoni. Silakan edit testimoni yang sudah ada.');
        }

        $request->validate([
            'isi_testimoni' => 'required|string|max:2000',
            'pekerjaan'     => 'nullable|string|max:100',
            'perusahaan'    => 'nullable|string|max:100',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $alumni = Alumni::where('user_id', $user->id)->where('status', 'approved')->first();

        $data = [
            'user_id'       => $user->id,
            'nama'          => $alumni->nama ?? $user->name,
            'jurusan'       => $alumni->prodi ?? 'Alumni',
            'tahun_lulus'   => $alumni->lulusan ?? now()->year,
            'isi_testimoni' => $request->isi_testimoni,
            'pekerjaan'     => $request->pekerjaan ?? $alumni->pekerjaan ?? null,
            'perusahaan'    => $request->perusahaan ?? $alumni->perusahaan ?? null,
            'status'        => 'pending',
            'alasan_penolakan' => null,
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('testimoni', 'public');
        }

        $testimonial = Testimonials::create($data);

        return redirect()->route('testimoni.index')
            ->with('success', 'Testimoni telah terkirim')
            ->with('success_detail', 'Menunggu review admin sebelum dipublikasikan.');
    }

    // Form edit testimoni
    public function edit(Testimonials $testimoni)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            abort(403, 'Admin hanya dapat approve atau reject testimoni.');
        }

        if ($testimoni->user_id !== $user->id) {
            abort(403);
        }

        $alumni = Alumni::where('user_id', $testimoni->user_id)->where('status', 'approved')->first();

        return view('testimoni.edit', compact('testimoni', 'alumni'));
    }

    // Update testimoni
    public function update(Request $request, Testimonials $testimoni)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            abort(403, 'Admin hanya dapat approve atau reject testimoni.');
        }

        if ($testimoni->user_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'isi_testimoni' => 'required|string|max:2000',
            'pekerjaan'     => 'nullable|string|max:100',
            'perusahaan'    => 'nullable|string|max:100',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'isi_testimoni' => $request->isi_testimoni,
            'pekerjaan'     => $request->pekerjaan,
            'perusahaan'    => $request->perusahaan,
            'status' => 'pending',
            'alasan_penolakan' => null,
            'approved_by' => null,
            'approved_at' => null,
        ];

        if ($request->hasFile('foto')) {
            if ($testimoni->foto) {
                Storage::disk('public')->delete($testimoni->foto);
            }
            $data['foto'] = $request->file('foto')->store('testimoni', 'public');
        }

        $testimoni->update($data);

        return redirect()->route('testimoni.index')
            ->with('success', 'Revisi testimoni telah terkirim')
            ->with('success_detail', 'Menunggu review admin sebelum dipublikasikan kembali.');
    }

    // Hapus testimoni (bisa oleh pemilik atau admin)
    public function destroy(Testimonials $testimoni)
    {
        $user = Auth::user();

        if ($testimoni->user_id !== $user->id && $user->role !== 'admin') {
            abort(403);
        }

        if ($testimoni->foto) {
            Storage::disk('public')->delete($testimoni->foto);
        }

        $testimoni->delete();

        return redirect()->route('testimoni.index')
            ->with('success', 'Testimoni berhasil dihapus.');
    }

    // === ADMIN METHODS ===

    // Menampilkan testimoni pending
    public function adminPending(Request $request)
    {
        $status = $request->input('status', 'pending');
        if (! in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $status = 'pending';
        }

        $query = Testimonials::with(['user', 'approver'])->where('status', $status);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('jurusan', 'like', '%' . $request->search . '%')
                  ->orWhere('pekerjaan', 'like', '%' . $request->search . '%')
                  ->orWhere('perusahaan', 'like', '%' . $request->search . '%')
                  ->orWhere('isi_testimoni', 'like', '%' . $request->search . '%');
            });
        }

        $testimonials = $query->latest()->paginate(15);
        $stats = [
            'pending' => Testimonials::pending()->count(),
            'approved' => Testimonials::approved()->count(),
            'rejected' => Testimonials::rejected()->count(),
        ];

        return view('admin.testimoni.pending', compact('testimonials', 'stats', 'status'));
    }

    public function approve(Testimonials $testimoni)
    {
        $testimoni->update([
            'status' => 'approved',
            'alasan_penolakan' => null,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.testimoni.pending')
            ->with('success', 'Testimoni berhasil disetujui.');
    }

    public function reject(Request $request, Testimonials $testimoni)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|min:10|max:1000',
        ]);

        $testimoni->update([
            'status' => 'rejected',
            'alasan_penolakan' => $request->alasan_penolakan,
            'approved_by' => Auth::id(),
            'approved_at' => null,
        ]);

        return redirect()->route('admin.testimoni.pending')
            ->with('success', 'Testimoni ditolak. Alumni dapat membaca alasan dan mengirim revisi.');
    }
}
