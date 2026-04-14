<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->except(['index', 'show']);
    }

    // Halaman publik daftar berita
    public function index()
    {
        $berita = Berita::orderBy('tanggal', 'desc')->paginate(10);
        return view('berita.index', compact('berita'));
    }

    // Halaman admin daftar berita
    public function adminIndex()
    {
        $berita = Berita::orderBy('tanggal', 'desc')->paginate(15);
        return view('admin.berita.index', compact('berita'));
    }

    // Halaman form tambah berita (admin)
    public function create()
    {
        return view('admin.berita.create');
    }

    // Simpan berita baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'   => 'required|string|max:150',
            'isi'     => 'required|string',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal' => 'nullable|date',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $validated['tanggal'] = $validated['tanggal'] ?? now();

        Berita::create($validated);

        return redirect()->route('admin.berita.index')->with('success', '✅ Berita berhasil ditambahkan!');
    }

    // Detail satu berita (publik)
    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        $lainnya = Berita::where('id', '!=', $id)
                    ->latest('tanggal')
                    ->take(3)
                    ->get();

        return view('berita.show', compact('berita', 'lainnya'));
    }

    // Halaman form edit berita (admin)
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

    // Update berita
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul'   => 'required|string|max:150',
            'isi'     => 'required|string',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal' => 'nullable|date',
        ]);

        $berita = Berita::findOrFail($id);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($validated);

        return redirect()->route('admin.berita.index')->with('success', '✅ Berita berhasil diperbarui!');
    }

    // Hapus berita
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', '🗑️ Berita berhasil dihapus!');
    }
}