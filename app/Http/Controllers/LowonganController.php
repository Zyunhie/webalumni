<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    /**
     * Tampilkan daftar lowongan
     */
    public function index(Request $request)
    {
        // Cek apakah user klik "lihat semua"
        $showAll = $request->query('all') == 1;

        // Ambil semua lowongan dari database, urut berdasarkan tanggal_post (pastikan kolom ada)
        $lowongan = Lowongan::orderByRaw('COALESCE(tanggal_posting, created_at) DESC')->get();

        return view('lowongan.index', compact('lowongan', 'showAll'));
    }

    /**
     * Tampilkan halaman detail lowongan
     */
    public function show($id)
{
    $lowongan = Lowongan::findOrFail($id);
    return view('lowongan.show', compact('lowongan'));
}


    /**
     * Tambah lowongan baru (API atau form)
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'perusahaan' => 'required|string|max:150',
            'lokasi' => 'nullable|string|max:150',
            'tanggal_post' => 'nullable|date',
            'batas_lamaran' => 'nullable|date',
            'gambar' => 'nullable|string|max:255',
        ]);

        $lowongan = Lowongan::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'perusahaan' => $request->perusahaan,
            'lokasi' => $request->lokasi,
            'tanggal_post' => $request->tanggal_post ?? now(),
            'batas_lamaran' => $request->batas_lamaran,
            'gambar' => $request->gambar,
        ]);

        return response()->json(['message' => 'Lowongan berhasil ditambahkan', 'data' => $lowongan]);
    }

    /**
     * Update lowongan
     */
    public function update(Request $request, $id)
    {
        $lowongan = Lowongan::findOrFail($id);

        $request->validate([
            'judul' => 'sometimes|required|string|max:150',
            'deskripsi' => 'sometimes|required|string',
            'perusahaan' => 'sometimes|required|string|max:150',
            'lokasi' => 'nullable|string|max:150',
            'tanggal_post' => 'nullable|date',
            'batas_lamaran' => 'nullable|date',
            'gambar' => 'nullable|string|max:255',
        ]);

        $lowongan->update($request->all());

        return response()->json(['message' => 'Lowongan berhasil diperbarui', 'data' => $lowongan]);
    }

    /**
     * Hapus lowongan
     */
    public function destroy($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $lowongan->delete();

        return response()->json(['message' => 'Lowongan berhasil dihapus']);
    }
}
