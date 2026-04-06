<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
        $this->middleware('role:admin')->only(['adminPending', 'approve', 'reject']);
    }

    public function index(Request $request)
    {
        if (auth()?->user()?->role === 'admin') {
            $query = Testimoni::with('user');
        } else {
            $query = Testimoni::approved()->with('user');
        }

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%'. $request->search .'%')
                  ->orWhere('pesan', 'like', '%'. $request->search .'%');
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
            'nama' => 'required|string|max:100',
            'angkatan' => 'nullable|string|max:10',
            'pekerjaan' => 'nullable|string|max:100',
            'pesan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto');
        $data['user_id'] = auth()->id();

        if (auth()->user()->role === 'admin') {
            $data['status'] = 'approved';
            $data['approved_by'] = auth()->id();
            $data['approved_at'] = now();
        } else {
            $data['status'] = 'pending';
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_testimoni', 'public');
        }

        Testimoni::create($data);

        return redirect()->route('testimoni.index')
            ->with('success', auth()->user()->role === 'admin' 
                ? 'Testimoni ditambahkan & disetujui.' 
                : 'Testimoni menunggu persetujuan admin.');
    }

    public function edit(Testimoni $testimoni)
    {
        if (auth()->user()->role != 'admin' && $testimoni->user_id !== auth()->id()) {
            abort(403);
        }

        return view('testimoni.edit', compact('testimoni'));
    }

    public function update(Request $request, Testimoni $testimoni)
    {
        if (auth()->user()->role != 'admin' && $testimoni->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'nama' => 'required|string|max:100',
            'angkatan' => 'nullable|string|max:10',
            'pekerjaan' => 'nullable|string|max:100',
            'pesan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($testimoni->foto) {
                Storage::disk('public')->delete($testimoni->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto_testimoni', 'public');
        }

        if (auth()->user()->role != 'admin') {
            $data['status'] = 'pending';
            $data['approved_by'] = null;
            $data['approved_at'] = null;
        }

        $testimoni->update($data);

        return redirect()->route('testimoni.index')->with('success', 'Testimoni diperbarui.');
    }

    public function destroy(Testimoni $testimoni)
    {
        if (auth()->user()->role != 'admin' && $testimoni->user_id !== auth()->id()) {
            abort(403);
        }

        if ($testimoni->foto) {
            Storage::disk('public')->delete($testimoni->foto);
        }

        $testimoni->delete();

        return redirect()->route('testimoni.index')->with('success', 'Testimoni dihapus.');
    }

    // Admin only
    public function adminPending()
    {
        $testimoni = Testimoni::where('status', 'pending')->with('user')->latest()->get();

        return view('admin.testimoni.pending', compact('testimoni'));
    }

    public function approve(Testimoni $testimoni)
    {
        $testimoni->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Testimoni disetujui.');
    }

    public function reject(Testimoni $testimoni)
    {
        $testimoni->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Testimoni ditolak.');
    }
}
