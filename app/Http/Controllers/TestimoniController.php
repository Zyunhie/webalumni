<?php

namespace App\Http\Controllers;

use App\Models\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index(Request $request)
    {
        if (auth()?->user()?->role === 'admin') {
            $query = Testimonials::with('user');
        } else {
            $query = Testimonials::approved()->with('user');
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('isi_testimoni', 'like', '%' . $request->search . '%');
            });
        }

        $testimonials = $query->latest()->paginate(12);
        return view('testimoni.index', compact('testimonials'));
    }

    public function create()
    {
        return view('testimoni.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'jurusan'       => 'required|string|max:100',
            'tahun_lulus'   => 'required|digits:4',
            'pekerjaan'     => 'nullable|string|max:100',
            'perusahaan'    => 'nullable|string|max:100',
            'isi_testimoni' => 'required|string|min:50',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only([
            'nama', 'jurusan', 'tahun_lulus', 'pekerjaan', 'perusahaan', 'isi_testimoni'
        ]);

        $data['user_id'] = auth()->id();

        if (auth()->user()->role === 'admin') {
            $data['status']      = 'approved';
            $data['approved_by'] = auth()->id();
            $data['approved_at'] = now();
        } else {
            $data['status'] = 'pending';
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_testimoni', 'public');
        }

        Testimonials::create($data);

        return redirect()->route('testimoni.index')
            ->with('success', 'Testimoni berhasil dikirim dan menunggu moderasi.');
    }

    // FIX: Method edit — pass variabel dengan nama $testimoni (sesuai route parameter)
    public function edit(Testimonials $testimoni)
    {
        // Pastikan hanya pemilik atau admin yang bisa edit
        if (auth()->id() !== $testimoni->user_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        return view('testimoni.edit', compact('testimoni'));
    }

    // FIX: Method update — lengkap dengan handle foto lama
    public function update(Request $request, Testimonials $testimoni)
    {
        // Pastikan hanya pemilik atau admin yang bisa update
        if (auth()->id() !== $testimoni->user_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'nama'          => 'required|string|max:100',
            'jurusan'       => 'required|string|max:100',
            'tahun_lulus'   => 'required|digits:4',
            'pekerjaan'     => 'nullable|string|max:100',
            'perusahaan'    => 'nullable|string|max:100',
            'isi_testimoni' => 'required|string|min:50',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only([
            'nama', 'jurusan', 'tahun_lulus', 'pekerjaan', 'perusahaan', 'isi_testimoni'
        ]);

        // Kalau bukan admin, reset ke pending karena ada perubahan
        if (auth()->user()->role !== 'admin') {
            $data['status']      = 'pending';
            $data['approved_by'] = null;
            $data['approved_at'] = null;
        }

        if ($request->hasFile('foto')) {
            // Hapus foto lama kalau ada
            if ($testimoni->foto) {
                Storage::disk('public')->delete($testimoni->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto_testimoni', 'public');
        }

        $testimoni->update($data);

        return redirect()->route('testimoni.index')
            ->with('success', 'Testimoni berhasil diupdate dan menunggu moderasi ulang.');
    }

    // FIX: Method destroy — dengan authorization check + hapus foto dari storage
    public function destroy(Testimonials $testimoni)
    {
        if (auth()->id() !== $testimoni->user_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Hapus foto dari storage kalau ada
        if ($testimoni->foto) {
            Storage::disk('public')->delete($testimoni->foto);
        }

        $testimoni->delete();

        return redirect()->route('testimoni.index')
            ->with('success', 'Testimoni berhasil dihapus.');
    }

    // Admin methods
    public function adminPending()
    {
        $pending = Testimonials::where('status', 'pending')->with('user')->latest()->get();
        return view('admin.testimoni.pending', compact('pending'));
    }

    public function approve(Testimonials $testimoni)
    {
        $testimoni->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Testimoni disetujui.');
    }

    public function reject(Request $request, Testimonials $testimoni)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:500',
        ]);

        $testimoni->update([
            'status'            => 'rejected',
            'alasan_penolakan'  => $request->alasan_penolakan,
        ]);

        return back()->with('success', 'Testimoni ditolak.');
    }
}