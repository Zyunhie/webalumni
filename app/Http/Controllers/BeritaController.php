<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Constructor untuk menambahkan middleware auth
     */
    public function __construct()
    {
        // Hanya method index yang bisa diakses semua orang
        // Method lainnya (show, store, update, destroy) harus login
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Tampilkan semua berita di halaman utama (bisa diakses publik)
     */
    public function index()
    {
        $berita = Berita::orderBy('tanggal', 'desc')->get();
        return view('berita.index', compact('berita'));
    }

    /**
     * Simpan berita baru (harus login)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'   => 'required|string|max:150',
            'isi'     => 'required|string',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal' => 'nullable|date',
        ]);

        // simpan gambar kalau ada
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        // kalau tanggal kosong, isi otomatis dengan tanggal hari ini
        $validated['tanggal'] = $validated['tanggal'] ?? now();

        Berita::create($validated);

        return redirect()->back()->with('success', '✅ Berita berhasil ditambahkan!');
    }

    /**
     * Detail satu berita (harus login)
     */
    public function show($id)
    {
        $berita = Berita::findOrFail($id);

        // ambil 3 berita lain untuk bagian "Berita Lainnya"
        $lainnya = Berita::where('id', '!=', $id)
                    ->latest()
                    ->take(3)
                    ->get();

        return view('berita.show', compact('berita', 'lainnya'));
    }

    /**
     * Update berita (harus login)
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul'   => 'required|string|max:150',
            'isi'     => 'required|string',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal' => 'nullable|date',
        ]);

        $berita = Berita::findOrFail($id);

        // hapus gambar lama kalau ada upload baru
        if ($request->hasFile('gambar')) {
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($validated);

        return redirect()->back()->with('success', '✅ Berita berhasil diperbarui!');
    }

    /**
     * Hapus berita (harus login)
     */
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->back()->with('success', '🗑️ Berita berhasil dihapus!');
    }
}
