<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index()
    {
        $alumni = Alumni::all();
        return response()->json($alumni);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'nullable|string|max:20',
            'prodi' => 'nullable|string|max:50',
            'angkatan' => 'nullable|integer',
            'pekerjaan' => 'nullable|string|max:100',
            'perusahaan' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $alumni = Alumni::create($request->all());
        return response()->json(['message' => 'Data alumni berhasil ditambahkan', 'data' => $alumni]);
    }

    public function show($id)
    {
        $alumni = Alumni::findOrFail($id);
        return response()->json($alumni);
    }

    public function update(Request $request, $id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->update($request->all());
        return response()->json(['message' => 'Data alumni berhasil diperbarui', 'data' => $alumni]);
    }

    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->delete();
        return response()->json(['message' => 'Data alumni berhasil dihapus']);
    }
}
