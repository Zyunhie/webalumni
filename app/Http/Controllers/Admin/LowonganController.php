<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendLowonganNotification;

class LowonganController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'semua');
        
        $query = Lowongan::with(['postedBy', 'approvedBy']);
        
        if ($status != 'semua') {
            $query->where('status', $status);
        }
        
        $lowongans = $query->paginate(10);
        
        return view('admin.lowongan.index', compact('lowongans', 'status'));
    }
    
    public function create()
    {
        return view('admin.lowongan.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
            'kualifikasi' => 'required|string',
            'cara_melamar' => 'required|string',
            'external_link' => 'nullable|url',
            'gambar' => 'nullable|image|max:2048', // jika ada upload gambar
            'target_prodi' => 'required|array',
            'target_prodi.*' => 'string',
            'is_internal' => 'boolean',
            'status' => 'in:pending,approved,rejected',
        ]);
        
        $validated['posted_by'] = auth()->id();
        $validated['target_prodi'] = array_filter($validated['target_prodi']);
        
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('lowongan', 'public');
        }
        
        Lowongan::create($validated);
        
        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }
    
    public function show(Lowongan $lowongan)
    {
        $lowongan->load(['postedBy', 'approvedBy', 'lamarans.alumni.user']);
        $lamarans = $lowongan->is_internal 
            ? $lowongan->lamarans()->with('alumni.user')->paginate(10) 
            : collect();
        
        return view('admin.lowongan.show', compact('lowongan', 'lamarans'));
    }
    
    public function edit(Lowongan $lowongan)
    {
        return view('admin.lowongan.edit', compact('lowongan'));
    }
    
    public function update(Request $request, Lowongan $lowongan)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
            'kualifikasi' => 'required|string',
            'cara_melamar' => 'required|string',
            'external_link' => 'nullable|url',
            'gambar' => 'nullable|image|max:2048',
            'target_prodi' => 'required|array',
            'target_prodi.*' => 'string',
            'is_internal' => 'boolean',
            'status' => 'in:pending,approved,rejected',
        ]);
        
        $validated['target_prodi'] = array_filter($validated['target_prodi']);
        
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('lowongan', 'public');
        }
        
        $lowongan->update($validated);
        
        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil diupdate.');
    }
    
    public function approve(Lowongan $lowongan)
    {
        $lowongan->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Lowongan berhasil diapprove.');
    }
    
    public function reject(Request $request, Lowongan $lowongan)
    {
        $request->validate(['rejection_reason' => 'required|string']);
        
        $lowongan->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);
        
        return redirect()->back()->with('success', 'Lowongan berhasil direject.');
    }
    
    public function sendNotification(Lowongan $lowongan)
    {
        if ($lowongan->status != 'approved') {
            return redirect()->back()->with('error', 'Hanya lowongan approved yang bisa dikirim notifikasi.');
        }
        
        if (!$lowongan->target_prodi || empty($lowongan->target_prodi)) {
            return redirect()->back()->with('error', 'Target prodi harus diisi.');
        }
        
        SendLowonganNotification::dispatch($lowongan);
        
        return redirect()->back()->with('success', 'Notifikasi sedang diproses via queue.');
    }
}