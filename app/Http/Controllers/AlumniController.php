<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * ===============================
     * FRONTEND (USER & UMUM)
     * ===============================
     */

    // LIST ALUMNI (HANYA APPROVED)
    public function index(Request $request)
    {
        $query = Alumni::where('status', 'approved');

        if ($request->angkatan) {
            $query->where('angkatan', $request->angkatan);
        }

        if ($request->lulusan) {
            $query->where('lulusan', $request->lulusan);
        }

        $alumni = $query->get();

        return view('alumni.index', compact('alumni'));
    }

    // FORM TAMBAH DATA (USER)
    public function create()
    {
        return view('alumni.create');
    }

    // SIMPAN DATA (PENDING)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'prodi' => 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['status']  = 'pending';

        Alumni::create($data);

        return redirect()
            ->route('alumni.index')
            ->with('success', 'Data berhasil dikirim dan menunggu persetujuan admin');
    }

    // DETAIL (HANYA APPROVED ATAU MILIK SENDIRI)
    public function show($id)
    {
        $alumni = Alumni::findOrFail($id);

        if (
            $alumni->status !== 'approved' &&
            $alumni->user_id !== auth()->id()
        ) {
            abort(403);
        }

        return view('alumni.show', compact('alumni'));
    }

    /**
     * ===============================
     * EDIT OLEH USER
     * ===============================
     */

    public function edit($id)
    {
        $alumni = Alumni::findOrFail($id);

        if ($alumni->user_id !== auth()->id()) {
            abort(403);
        }

        return view('alumni.edit', compact('alumni'));
    }

    public function update(Request $request, $id)
    {
        $alumni = Alumni::findOrFail($id);

        if ($alumni->user_id !== auth()->id()) {
            abort(403);
        }

        $alumni->update([
            'nama'        => $request->nama,
            'pekerjaan'   => $request->pekerjaan,
            'perusahaan'  => $request->perusahaan,
            'alamat'      => $request->alamat,

            // ⬇️ KUNCI KONSEP KAMU
            'status'      => 'pending',
            'approved_by' => null,
            'approved_at' => null,
        ]);

        return back()->with(
            'success',
            'Perubahan disimpan dan menunggu verifikasi admin'
        );
    }

    /**
     * ===============================
     * ADMIN AREA (TAMBAHAN FITUR)
     * ===============================
     */

    // LIST DATA PENDING
    public function pending()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $alumni = Alumni::where('status', 'pending')->get();

        return view('admin.alumni.pending', compact('alumni'));
    }

    // APPROVE
    public function approve($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $alumni = Alumni::findOrFail($id);

        $alumni->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Data alumni disetujui');
    }

    // REJECT
    public function reject($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $alumni = Alumni::findOrFail($id);

        $alumni->update([
            'status'      => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('error', 'Data alumni ditolak');
    }
}
