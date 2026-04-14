<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Alumni;
use App\Models\Lamaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LowonganController extends Controller
{
    public function index(Request $request)
    {
        $prodiFilter = $request->query('prodi');
        $search = $request->query('search');
        
        $query = Lowongan::approved()->orderBy('created_at', 'desc');
        
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
        
        $prodis = ['pgmi', 'pai', 'piaud', 'mpi', 'bkpi', 'eksyar', 'as', 'htn', 'pai-s2'];

        return view('lowongan.index', compact('lowongans', 'prodiFilter', 'search', 'prodis'));
    }

    public function show(Lowongan $lowongan)
    {
        // Hitung alumni di perusahaan ini (opsional, sesuaikan kolom di tabel alumni)
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
        
        return view('lowongan.show', compact('lowongan', 'alumniCount', 'canApply', 'alreadyApplied'));
    }
    
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
            'cv_file' => 'nullable|file|mimes:pdf|max:2048',
        ]);
        
        DB::transaction(function () use ($request, $lowongan) {
            auth()->user()->alumni->lamarans()->create([
                'lowongan_id' => $lowongan->id,
                'cover_letter' => $request->cover_letter,
                'cv_file' => $request->file('cv_file') 
                    ? $request->file('cv_file')->store('cv', 'public') 
                    : null,
                'status' => 'menunggu',
            ]);
        });
        
        return redirect()->back()->with('success', 'Lamaran berhasil dikirim dan menunggu proses!');
    }
    
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
}