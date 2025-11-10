<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimoni = Testimoni::all();
        return response()->json($testimoni);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'angkatan' => 'nullable|string|max:10',
            'pekerjaan' => 'nullable|string|max:100',
            'pesan' => 'required|string',
            'foto' => 'nullable|string|max:255',
        ]);

        $testimoni = Testimoni::create($request->all());
        return response()->json(['message' => 'Testimoni berhasil ditambahkan', 'data' => $testimoni]);
    }

    public function show($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        return response()->json($testimoni);
    }

    public function update(Request $request, $id)
    {
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->update($request->all());
        return response()->json(['message' => 'Testimoni berhasil diperbarui', 'data' => $testimoni]);
    }

    public function destroy($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->delete();
        return response()->json(['message' => 'Testimoni berhasil dihapus']);
    }
}
