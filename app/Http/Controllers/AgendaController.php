<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgendaController extends Controller
{
    // Constructor untuk menambahkan middleware auth hanya pada method tertentu
    public function __construct()
    {
        // Hanya user yang login boleh akses create, update, delete, show detail
        $this->middleware('auth')->except(['index']);
    }

    // Menampilkan semua agenda (read-only, bisa diakses semua orang)
    public function index()
    {
        $agendas = Agenda::orderBy('tanggal_mulai', 'asc')->get();
        return view('alumni.agenda', compact('agendas'));
    }

    // Menambahkan agenda (harus login)
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'nullable|string|max:150',
        ]);

        $agendaData = $request->all();
        if ($request->hasFile('gambar')) {
            $agendaData['gambar'] = $request->file('gambar')->store('agendas', 'public');
        }

        $agenda = Agenda::create($agendaData);
        return redirect()->route('alumni.agenda')->with('success', 'Agenda berhasil ditambahkan!');
    }

    public function destroyAll()
    {
        Agenda::truncate();
        return redirect()->route('alumni.agenda')->with('success', 'Semua agenda berhasil dihapus!');
    }

    // Menampilkan detail agenda untuk edit
    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        return view('alumni.agenda', compact('agenda'));
    }

    // Update agenda
    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'nullable|string|max:150',
        ]);

        $agendaData = $request->all();
        if ($request->hasFile('gambar')) {
            if ($agenda->gambar) {
                Storage::disk('public')->delete($agenda->gambar);
            }
            $agendaData['gambar'] = $request->file('gambar')->store('agendas', 'public');
        }

        $agenda->update($agendaData);
        return redirect()->route('alumni.agenda')->with('success', 'Agenda berhasil diupdate!');
    }

    // Menampilkan detail agenda (harus login)
    public function show($id)
    {
        $agenda = Agenda::findOrFail($id);
        return response()->json($agenda);
    }



    // Hapus agenda (harus login)
    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        if ($agenda->gambar) {
            Storage::disk('public')->delete($agenda->gambar);
        }
        $agenda->delete();
        return redirect()->route('alumni.agenda')->with('success', 'Agenda berhasil dihapus!');
    }
}
