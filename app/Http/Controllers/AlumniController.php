<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    // === INDEX: Menampilkan daftar alumni PGMI ===
    public function pgmiIndex(Request $request)
{
    $angkatan = $request->get('angkatan');
    $lulusan = $request->get('lulusan');

    $query = Alumni::where('prodi', 'PGMI');

    if ($angkatan && $angkatan !== 'all') {
        $query->where('angkatan', $angkatan);
    }

    if ($lulusan && $lulusan !== 'all') {
        $query->where('lulusan', $lulusan);
    }

    $alumni = $query->get();
    $angkatanList = Alumni::where('prodi', 'PGMI')->select('angkatan')->distinct()->pluck('angkatan');
    $lulusanList = Alumni::where('prodi', 'PGMI')->select('lulusan')->distinct()->pluck('lulusan');

    return view('alumni.s1.prodi.pgmi.index', compact('alumni', 'angkatan', 'lulusan', 'angkatanList', 'lulusanList'));
}

    // === CREATE: Form tambah data alumni ===
    public function createPgmi()
    {
        return view('alumni.s1.pgmi.create');
    }

    // === STORE: Simpan data alumni baru ===
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'nullable|string|max:20',
            'prodi' => 'required|string|max:50',
            'angkatan' => 'nullable|integer',
            'lulusan' => 'nullable|integer',
            'pekerjaan' => 'nullable|string|max:100',
            'perusahaan' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'transkrip_nilai' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $data = $request->except(['foto', 'ijazah', 'transkrip_nilai']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('uploads/foto', 'public');
        }
        if ($request->hasFile('ijazah')) {
            $data['ijazah'] = $request->file('ijazah')->store('uploads/ijazah', 'public');
        }
        if ($request->hasFile('transkrip_nilai')) {
            $data['transkrip_nilai'] = $request->file('transkrip_nilai')->store('uploads/transkrip', 'public');
        }

        Alumni::create($data);

        return redirect()->route('alumni.s1.pgmi')->with('success', 'Data alumni berhasil ditambahkan!');
    }

    // === SHOW: Detail alumni ===
    public function pgmiShow($id)
{
    $alumni = \App\Models\Alumni::findOrFail($id);
    return view('alumni.s1.pgmi.show', compact('alumni'));
}
}
