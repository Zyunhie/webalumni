<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\HeroSlide;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    // Halaman publik kontak
    public function index()
    {
        $heroKontak = HeroSlide::where('page', 'kontak')->where('aktif', true)->first();
        return view('kontak', compact('heroKontak'));
    }

    // Simpan pesan dari form kontak
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pesan' => 'required|string',
        ]);

        Pesan::create($validated);

        return redirect()->route('kontak')->with('success', 'Pesan Anda telah terkirim. Terima kasih!');
    }

    // Admin: Daftar pesan
    public function adminIndex(Request $request)
    {
        $HeroKontak = HeroSlide::where('page', 'kontak')->where('aktif', true)->first();

        $query = Pesan::query();

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date   . ' 23:59:59',
            ]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pesans = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.kontak.index', compact('HeroKontak', 'pesans'));
    }

    // Admin: Tandai sudah dibaca
    public function markAsRead(Pesan $pesan)
    {
        $pesan->update([
            'status'      => 'dibaca',
            'dibaca_pada' => now(),
        ]);

        return redirect()->back()->with('success', 'Pesan ditandai sudah dibaca.');
    }

    // Admin: Hapus pesan
    public function destroy(Pesan $pesan)
    {
        $pesan->delete();
        return redirect()->back()->with('success', 'Pesan berhasil dihapus.');
    }

    // Admin: Tandai semua sebagai dibaca
    public function markAllAsRead()
    {
        Pesan::where('status', 'belum_dibaca')->update([
            'status'      => 'dibaca',
            'dibaca_pada' => now(),
        ]);

        return redirect()->back()->with('success', 'Semua pesan ditandai sudah dibaca.');
    }
}