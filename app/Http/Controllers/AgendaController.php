<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        $agenda = Agenda::all();
        return response()->json($agenda);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'lokasi' => 'nullable|string|max:150',
            'gambar' => 'nullable|string|max:255',
        ]);

        $agenda = Agenda::create($request->all());
        return response()->json(['message' => 'Agenda berhasil ditambahkan', 'data' => $agenda]);
    }

    public function show($id)
    {
        $agenda = Agenda::findOrFail($id);
        return response()->json($agenda);
    }

    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->update($request->all());
        return response()->json(['message' => 'Agenda berhasil diperbarui', 'data' => $agenda]);
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();
        return response()->json(['message' => 'Agenda berhasil dihapus']);
    }
}
