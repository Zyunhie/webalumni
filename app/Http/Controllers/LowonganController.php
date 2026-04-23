<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Alumni;
use App\Models\Lamaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class LowonganController extends Controller
{
    /**
     * Menampilkan daftar lowongan untuk publik / alumni.
     */
    public function index(Request $request)
    {
        $prodiFilter = $request->query('prodi');
        $search      = $request->query('search');

        $query = Lowongan::approved()->orderBy('created_at', 'desc');

        // Filter otomatis berdasarkan prodi alumni yang sedang login
        if (auth()->check() && auth()->user()->role === 'alumni') {
            $alumniProdi = auth()->user()->alumni->prodi ?? null;
            if ($alumniProdi) {
                $query->forProdi($alumniProdi);
            }
        }

        if ($prodiFilter) {
            $query->forProdi($prodiFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('perusahaan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        $lowongans = $query->paginate(12);
        $prodis    = ['pgmi', 'pai', 'piaud', 'mpi', 'bkpi', 'eksyar', 'as', 'htn', 'pai-s2'];

        return view('lowongan.index', compact('lowongans', 'prodiFilter', 'search', 'prodis'));
    }

    /**
     * Menampilkan detail lowongan.
     */
    public function show(Lowongan $lowongan)
    {
        $alumniCount = 0;
        if (Schema::hasColumn('alumni', 'perusahaan')) {
            $alumniCount = Alumni::where('status', 'approved')
                ->where('perusahaan', 'like', '%' . $lowongan->perusahaan . '%')
                ->count();
        }

        $canApply = auth()->check()
            && auth()->user()->role === 'alumni'
            && auth()->user()->alumni
            && auth()->user()->alumni->status === 'approved'
            && $lowongan->status === 'approved';

        $alreadyApplied = false;
        if ($canApply) {
            $alreadyApplied = auth()->user()->alumni->lamarans()
                ->where('lowongan_id', $lowongan->id)
                ->exists();
        }

        // Cek apakah alumni ini pemilik lowongan
        $isOwner = auth()->check() && $lowongan->posted_by === auth()->id();

        return view('lowongan.show', compact('lowongan', 'alumniCount', 'canApply', 'alreadyApplied', 'isOwner'));
    }

    /**
     * Proses melamar lowongan.
     */
    public function lamar(Request $request, Lowongan $lowongan)
    {
        if (!auth()->check() || auth()->user()->role !== 'alumni' || !auth()->user()->alumni || auth()->user()->alumni->status !== 'approved') {
            return redirect()->back()->with('error', 'Hanya alumni approved yang bisa melamar.');
        }

        if ($lowongan->status !== 'approved') {
            return redirect()->back()->with('error', 'Lowongan belum disetujui.');
        }

        $request->validate([
            'cover_letter' => 'nullable|string|max:1000',
            'cv_file'      => 'nullable|file|mimes:pdf|max:2048',
        ]);

        DB::transaction(function () use ($request, $lowongan) {
            auth()->user()->alumni->lamarans()->create([
                'lowongan_id'  => $lowongan->id,
                'cover_letter' => $request->cover_letter,
                'cv_file'      => $request->file('cv_file')
                    ? $request->file('cv_file')->store('cv', 'public')
                    : null,
                'status'       => 'menunggu',
            ]);
        });

        return redirect()->back()->with('success', 'Lamaran berhasil dikirim dan menunggu proses!');
    }

    /**
     * Dashboard khusus alumni: lowongan sesuai prodi & tren pekerjaan.
     */
    public function dashboard()
    {
        $alumni = auth()->user()->alumni;

        if (!$alumni) {
            return redirect()->route('dashboard')->with('error', 'Profil alumni tidak ditemukan.');
        }

        $lowongans = Lowongan::approved()
            ->forProdi($alumni->prodi)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $populerJobs = Alumni::where('status', 'approved')
            ->where('prodi', $alumni->prodi)
            ->whereNotNull('pekerjaan')
            ->select('pekerjaan', DB::raw('count(*) as count'))
            ->groupBy('pekerjaan')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->pluck('pekerjaan', 'count')
            ->sortByDesc('count');

        return view('lowongan.dashboard', compact('lowongans', 'populerJobs'));
    }

    // ─── Alumni: CRUD Lowongan Milik Sendiri ───────────────────────────

    /**
     * Menampilkan daftar lowongan yang dibuat oleh alumni yang sedang login.
     * Urutan: paling baru di atas (created_at DESC).
     */
    public function myLowongan()
    {
        $lowongans = Lowongan::where('posted_by', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('lowongan.my', compact('lowongans'));
    }

    /**
     * Form tambah lowongan baru oleh alumni.
     */
    public function create()
    {
        $prodis = ['pgmi', 'pai', 'piaud', 'mpi', 'bkpi', 'eksyar', 'as', 'htn', 'pai-s2'];
        return view('lowongan.create', compact('prodis'));
    }

    /**
     * Simpan lowongan baru (status pending, menunggu approval admin).
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'          => 'required|string|max:255',
            'perusahaan'     => 'required|string|max:255',
            'lokasi'         => 'nullable|string|max:255',
            'deskripsi'      => 'nullable|string',
            'kualifikasi'    => 'nullable|string',
            'cara_melamar'   => 'nullable|string',
            'external_link'  => 'nullable|url',
            'gambar'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'target_prodi'   => 'required|array|min:1',
            'target_prodi.*' => 'in:pgmi,pai,piaud,mpi,bkpi,eksyar,as,htn,pai-s2',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('lowongan', 'public');
        }

        Lowongan::create([
            'judul'         => $request->judul,
            'perusahaan'    => $request->perusahaan,
            'lokasi'        => $request->lokasi,
            'deskripsi'     => $request->deskripsi,
            'kualifikasi'   => $request->kualifikasi,
            'cara_melamar'  => $request->cara_melamar,
            'external_link' => $request->external_link,
            'gambar'        => $gambarPath,
            'target_prodi'  => $request->target_prodi,
            'status'        => 'pending',
            'is_internal'   => false,
            'posted_by'     => auth()->id(),
        ]);

        return redirect()->route('alumni.lowongan.my')
            ->with('success', 'Lowongan berhasil diajukan dan menunggu persetujuan admin.');
    }

    /**
     * Form edit lowongan milik sendiri.
     */
    public function edit(Lowongan $lowongan)
    {
        if ($lowongan->posted_by !== auth()->id()) {
            abort(403, 'Anda tidak punya akses untuk mengedit lowongan ini.');
        }

        $prodis = ['pgmi', 'pai', 'piaud', 'mpi', 'bkpi', 'eksyar', 'as', 'htn', 'pai-s2'];
        return view('lowongan.edit', compact('lowongan', 'prodis'));
    }

    /**
     * Update lowongan (status kembali pending setelah edit).
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        if ($lowongan->posted_by !== auth()->id()) {
            abort(403, 'Anda tidak punya akses untuk mengedit lowongan ini.');
        }

        $request->validate([
            'judul'          => 'required|string|max:255',
            'perusahaan'     => 'required|string|max:255',
            'lokasi'         => 'nullable|string|max:255',
            'deskripsi'      => 'nullable|string',
            'kualifikasi'    => 'nullable|string',
            'cara_melamar'   => 'nullable|string',
            'external_link'  => 'nullable|url',
            'gambar'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'target_prodi'   => 'required|array|min:1',
            'target_prodi.*' => 'in:pgmi,pai,piaud,mpi,bkpi,eksyar,as,htn,pai-s2',
        ]);

        $gambarPath = $lowongan->gambar; // keep existing
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($lowongan->gambar) {
                Storage::disk('public')->delete($lowongan->gambar);
            }
            $gambarPath = $request->file('gambar')->store('lowongan', 'public');
        }

        $lowongan->update([
            'judul'         => $request->judul,
            'perusahaan'    => $request->perusahaan,
            'lokasi'        => $request->lokasi,
            'deskripsi'     => $request->deskripsi,
            'kualifikasi'   => $request->kualifikasi,
            'cara_melamar'  => $request->cara_melamar,
            'external_link' => $request->external_link,
            'gambar'        => $gambarPath,
            'target_prodi'  => $request->target_prodi,
            'status'        => 'pending',
        ]);

        return redirect()->route('alumni.lowongan.my')
            ->with('success', 'Lowongan diperbarui dan menunggu persetujuan admin kembali.');
    }
}