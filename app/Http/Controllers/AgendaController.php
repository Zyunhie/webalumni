<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgendaController extends Controller
{
    public function __construct()
    {
        // Hanya method index dan show yang bisa diakses publik
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Menampilkan semua agenda (read-only, bisa diakses semua orang).
     */
    public function index()
    {
        $agendas = Agenda::orderBy('tanggal_mulai', 'asc')->get();
        return view('alumni.agenda', compact('agendas'));
    }

    /**
     * Menampilkan detail agenda (public).
     */
    public function show($id)
    {
        $agenda = Agenda::findOrFail($id);
        return view('alumni.agenda-show', compact('agenda'));
    }

    /**
     * Mengembalikan data agenda dalam format JSON (untuk keperluan edit modal).
     * Hanya admin yang bisa mengakses.
     */
    public function edit($id)
    {
        $this->authorizeAdmin();

        $agenda = Agenda::findOrFail($id);
        return response()->json($agenda);
    }

    /**
     * Menyimpan agenda baru (admin only).
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'judul'          => 'required|string|max:150',
            'deskripsi'      => 'required|string',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'nullable|date|after_or_equal:tanggal_mulai',
            'lokasi'         => 'nullable|string|max:150',
        ]);

        $agendaData = $request->all();
        if ($request->hasFile('gambar')) {
            $agendaData['gambar'] = $request->file('gambar')->store('agendas', 'public');
        }

        Agenda::create($agendaData);
        return redirect()->route('alumni.agenda')->with('success', 'Agenda berhasil ditambahkan!');
    }

    /**
     * Memperbarui agenda (admin only).
     */
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $agenda = Agenda::findOrFail($id);

        $request->validate([
            'judul'          => 'required|string|max:150',
            'deskripsi'      => 'required|string',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'nullable|date|after_or_equal:tanggal_mulai',
            'lokasi'         => 'nullable|string|max:150',
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

    /**
     * Menghapus satu agenda (admin only).
     */
    public function destroy($id)
    {
        $this->authorizeAdmin();

        $agenda = Agenda::findOrFail($id);
        if ($agenda->gambar) {
            Storage::disk('public')->delete($agenda->gambar);
        }
        $agenda->delete();

        return redirect()->route('alumni.agenda')->with('success', 'Agenda berhasil dihapus!');
    }

    /**
     * Menghapus semua agenda (admin only).
     */
    public function destroyAll()
    {
        $this->authorizeAdmin();

        // Hapus semua file gambar terkait
        $agendas = Agenda::all();
        foreach ($agendas as $agenda) {
            if ($agenda->gambar) {
                Storage::disk('public')->delete($agenda->gambar);
            }
        }

        Agenda::truncate();
        return redirect()->route('alumni.agenda')->with('success', 'Semua agenda berhasil dihapus!');
    }

    /**
     * Helper untuk memastikan user yang login adalah admin.
     * Jika bukan, lempar 403 Forbidden.
     */
    protected function authorizeAdmin()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Akses ditolak. Hanya admin yang dapat melakukan tindakan ini.');
        }
    }
}