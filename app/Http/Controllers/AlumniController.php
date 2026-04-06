<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    /**
     * Constructor untuk middleware
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('role:admin')->only(['pending', 'approve', 'reject']);
    }

    /**
     * ===============================
     * LIST ALUMNI - DYNAMIC BERDASARKAN PRODI
     * ADMIN: BISA LIHAT SEMUA STATUS
     * ===============================
     */
    public function index(Request $request)
    {
        // Deteksi prodi dari route name
        $prodi = null;
        $routeName = $request->route()->getName();
        
        if (str_contains($routeName, 'alumni.s1.pgmi')) {
            $prodi = 'PGMI';
        } elseif (str_contains($routeName, 'alumni.s1.pai')) {
            $prodi = 'PAI';
        } elseif (str_contains($routeName, 'alumni.s1.piaud')) {
            $prodi = 'PIAUD';
        } elseif (str_contains($routeName, 'alumni.s1.mpi')) {
            $prodi = 'MPI';
        } elseif (str_contains($routeName, 'alumni.s1.bkpi')) {
            $prodi = 'BKPI';
        } elseif (str_contains($routeName, 'alumni.s1.eksyar')) {
            $prodi = 'EKSYAR';
        } elseif (str_contains($routeName, 'alumni.s1.as')) {
            $prodi = 'AS';
        } elseif (str_contains($routeName, 'alumni.s1.htn')) {
            $prodi = 'HTN';
        } elseif (str_contains($routeName, 'alumni.s2.pai')) {
            $prodi = 'PAI (S2)';
        }

        // Jika admin, tampilkan semua alumni (approved, pending, rejected)
        // Jika user biasa, hanya tampilkan yang approved
        if (auth()->check() && auth()->user()->role === 'admin') {
            $query = Alumni::query();
        } else {
            $query = Alumni::where('status', 'approved');
        }

        // Filter berdasarkan prodi jika terdeteksi
        if ($prodi) {
            $query->where('prodi', $prodi);
        }

        // Filter tambahan dari request
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        if ($request->filled('angkatan') && $request->angkatan !== 'all') {
            $query->where('angkatan', $request->angkatan);
        }

        if ($request->filled('lulusan') && $request->lulusan !== 'all') {
            $query->where('lulusan', $request->lulusan);
        }

        $alumni = $query->latest()->paginate(20);

        // Tentukan view berdasarkan route name
        $viewName = 'alumni.index'; // default
        
        // Jika route adalah alumni.s1.*, gunakan view yang sesuai
        if (str_contains($routeName, 'alumni.s1.pgmi')) {
            $viewName = 'alumni.s1.pgmi.index';
        } elseif (str_contains($routeName, 'alumni.s1.')) {
            $viewName = 'alumni.s1.pgmi.index';
        } elseif (str_contains($routeName, 'alumni.s2.')) {
            $viewName = 'alumni.s1.pgmi.index';
        }

        // Untuk filter (ambil daftar angkatan & lulusan unik dari semua data)
        $angkatanList = Alumni::distinct()->orderBy('angkatan', 'desc')->pluck('angkatan');
        $lulusanList = Alumni::distinct()->orderBy('lulusan', 'desc')->pluck('lulusan');

        return view($viewName, compact('alumni', 'angkatanList', 'lulusanList', 'prodi'));
    }

    /**
     * ===============================
     * FORM TAMBAH DATA (USER LOGIN)
     * ===============================
     */
    public function create(Request $request)
    {
        // Deteksi prodi dari route name
        $routeName = $request->route()->getName();
        $selectedProdi = null;
        
        if (str_contains($routeName, 'alumni.s1.pgmi')) {
            $selectedProdi = 'PGMI';
        } elseif (str_contains($routeName, 'alumni.s1.pai')) {
            $selectedProdi = 'PAI';
        } elseif (str_contains($routeName, 'alumni.s1.piaud')) {
            $selectedProdi = 'PIAUD';
        } elseif (str_contains($routeName, 'alumni.s1.mpi')) {
            $selectedProdi = 'MPI';
        } elseif (str_contains($routeName, 'alumni.s1.bkpi')) {
            $selectedProdi = 'BKPI';
        } elseif (str_contains($routeName, 'alumni.s1.eksyar')) {
            $selectedProdi = 'EKSYAR';
        } elseif (str_contains($routeName, 'alumni.s1.as')) {
            $selectedProdi = 'AS';
        } elseif (str_contains($routeName, 'alumni.s1.htn')) {
            $selectedProdi = 'HTN';
        } elseif (str_contains($routeName, 'alumni.s2.pai')) {
            $selectedProdi = 'PAI (S2)';
        }

        return view('alumni.create', compact('selectedProdi'));
    }

    /**
     * SIMPAN DATA BARU (STATUS: PENDING JIKA USER, APPROVED JIKA ADMIN)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:100',
            'nim'        => 'nullable|string|max:20|unique:alumni,nim',
            'prodi'      => 'required|string|max:50',
            'angkatan'   => 'nullable|integer|min:2000|max:' . date('Y'),
            'lulusan'    => 'nullable|integer|min:2000|max:' . (date('Y')+5),
            'pekerjaan'  => 'nullable|string|max:100',
            'perusahaan' => 'nullable|string|max:100',
            'email'      => 'nullable|email|max:100',
            'no_hp'      => 'nullable|string|max:20',
            'alamat'     => 'nullable|string',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ijazah'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'transkrip'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except(['foto', 'ijazah', 'transkrip']);
        $data['user_id'] = auth()->id();

        // POIN 2: Jika admin yang menambah data → langsung approved
        // Jika user biasa → status pending (perlu approve)
        if (auth()->user()->role === 'admin') {
            $data['status'] = 'approved';
            $data['approved_by'] = auth()->id();
            $data['approved_at'] = now();
        } else {
            $data['status'] = 'pending';
        }

        if ($request->hasFile('ijazah')) {
            $data['ijazah'] = $request->file('ijazah')->store('ijazah', 'public');
        }
        if ($request->hasFile('transkrip')) {
            $data['transkrip'] = $request->file('transkrip')->store('transkrip', 'public');
        }
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_alumni', 'public');
        }

        Alumni::create($data);

        // POIN 1: Redirect balik ke halaman prodi tempat user nambahin data
        $prodi = $request->prodi;
        $redirectRoute = $this->getProdiRoute($prodi);

        if (auth()->user()->role === 'admin') {
            return redirect()->route($redirectRoute . '.index')
                ->with('success', 'Data alumni berhasil ditambahkan dan langsung disetujui.');
        } else {
            return redirect()->route($redirectRoute . '.index')
                ->with('success', 'Data berhasil dikirim dan menunggu persetujuan admin.');
        }
    }

    /**
     * Helper: Get route prefix berdasarkan prodi
     */
    private function getProdiRoute($prodi)
    {
        $routes = [
            'PGMI' => 'alumni.s1.pgmi',
            'PAI' => 'alumni.s1.pai',
            'PIAUD' => 'alumni.s1.piaud',
            'MPI' => 'alumni.s1.mpi',
            'BKPI' => 'alumni.s1.bkpi',
            'EKSYAR' => 'alumni.s1.eksyar',
            'AS' => 'alumni.s1.as',
            'HTN' => 'alumni.s1.htn',
            'PAI (S2)' => 'alumni.s2.pai',
        ];

        return $routes[$prodi] ?? 'alumni.s1.pgmi';
    }

    /**
     * ===============================
     * DETAIL ALUMNI (PUBLIC HANYA APPROVED, ATAU PEMILIK/ADMIN)
     * ===============================
     */
    public function show($id)
    {
        $alumni = Alumni::findOrFail($id);

        // Jika status approved, boleh siapa saja lihat
        // Jika tidak approved, hanya admin atau pemilik yang bisa lihat
        if ($alumni->status !== 'approved' && 
            auth()->user()->role !== 'admin' && 
            $alumni->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak mengakses data ini.');
        }

        return view('alumni.show', compact('alumni'));
    }

    /**
     * ===============================
     * EDIT DATA (ADMIN ATAU PEMILIK)
     * ===============================
     */
    public function edit($id)
    {
        $alumni = Alumni::findOrFail($id);

        // Izinkan jika admin atau pemilik data
        if (auth()->user()->role != 'admin' && $alumni->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('alumni.edit', compact('alumni'));
    }

    /**
     * UPDATE DATA
     */
    public function update(Request $request, $id)
    {
        $alumni = Alumni::findOrFail($id);

        // Cek otorisasi
        if (auth()->user()->role != 'admin' && $alumni->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'nama'       => 'required|string|max:100',
            'nim'        => 'nullable|string|max:20|unique:alumni,nim,' . $alumni->id,
            'prodi'      => 'required|string|max:50',
            'angkatan'   => 'nullable|integer|min:1950|max:' . date('Y'),
            'lulusan'    => 'nullable|integer|min:1950|max:' . (date('Y') + 5),
            'pekerjaan'  => 'nullable|string|max:100',
            'perusahaan' => 'nullable|string|max:100',
            'email'      => 'nullable|email|max:100',
            'no_hp'      => 'nullable|string|max:20',
            'alamat'     => 'nullable|string',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ijazah'     => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:5120',
            'transkrip'  => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:5120',
        ]);

        $data = $request->except(['foto', 'ijazah', 'transkrip']);

        // Foto
        if ($request->hasFile('foto')) {
            if ($alumni->foto) Storage::disk('public')->delete($alumni->foto);
            $data['foto'] = $request->file('foto')->store('foto_alumni', 'public');
        }

        // Ijazah
        if ($request->hasFile('ijazah')) {
            if ($alumni->ijazah) Storage::disk('public')->delete($alumni->ijazah);
            $data['ijazah'] = $request->file('ijazah')->store('ijazah', 'public');
        }

        // Transkrip
        if ($request->hasFile('transkrip')) {
            if ($alumni->transkrip) Storage::disk('public')->delete($alumni->transkrip);
            $data['transkrip'] = $request->file('transkrip')->store('transkrip', 'public');
        }

        // Jika yang edit adalah user biasa (bukan admin), kembalikan status ke pending
        if (auth()->user()->role != 'admin') {
            $data['status']      = 'pending';
            $data['approved_by'] = null;
            $data['approved_at'] = null;
        }
        // Jika admin, status tetap seperti sebelumnya

        $alumni->update($data);

        return redirect()->route('alumni.s1.pgmi.show', $alumni->id)
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * HAPUS DATA (ADMIN ATAU PEMILIK)
     */
    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);

        // Hanya admin atau pemilik yang boleh hapus
        if (auth()->user()->role != 'admin' && $alumni->user_id !== auth()->id()) {
            abort(403);
        }

        // Hapus file-file terkait
        if ($alumni->foto) {
            Storage::disk('public')->delete($alumni->foto);
        }
        if ($alumni->ijazah) {
            Storage::disk('public')->delete($alumni->ijazah);
        }
        if ($alumni->transkrip) {
            Storage::disk('public')->delete($alumni->transkrip);
        }

        $alumni->delete();

        return redirect()->route('alumni.s1.pgmi.index')
            ->with('success', 'Data alumni berhasil dihapus.');
    }

    /**
     * ===============================
     * PROFIL ALUMNI (DATA MILIK SENDIRI)
     * ===============================
     */
    public function profile()
    {
        $user = auth()->user();
        $alumni = Alumni::where('user_id', $user->id)->get();

        return view('alumni.profile', compact('alumni'));
    }

    /**
     * ===============================
     * ADMIN: LIST PENDING
     * ===============================
     */
    public function pending()
    {
        $alumni = Alumni::where('status', 'pending')
            ->with('user')
            ->latest()
            ->get();

        return view('admin.alumni.pending', compact('alumni'));
    }

    /**
     * ADMIN: APPROVE
     */
    public function approve($id)
    {
        $alumni = Alumni::findOrFail($id);

        $alumni->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Data alumni disetujui.');
    }

    /**
     * ADMIN: REJECT
     */
    public function reject($id)
    {
        $alumni = Alumni::findOrFail($id);

        $alumni->update([
            'status'      => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('error', 'Data alumni ditolak.');
    }

    /**
     * DOWNLOAD TEMPLATE CSV (tanpa package Excel)
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_alumni.csv"',
        ];

        $data = [
            ['nama', 'nim', 'prodi', 'angkatan', 'lulusan', 'pekerjaan', 'perusahaan', 'email', 'no_hp', 'alamat'],
            ['Contoh Nama Alumni', '123456789', 'PGMI', '2020', '2024', 'Guru', 'SDN 1 Tasikmalaya', 'email@example.com', '081234567890', 'Jl. Contoh No. 1, Tasikmalaya'],
        ];

        $callback = function() use ($data) {
            $handle = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * IMPORT DATA ALUMNI DARI CSV/EXCEL
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls'
        ]);

        // Untuk CSV manual processing
        if ($request->file('file')->getClientOriginalExtension() === 'csv') {
            try {
                $handle = fopen($request->file('file')->getRealPath(), 'r');
                $header = fgetcsv($handle);
                
                $imported = 0;
                while (($row = fgetcsv($handle)) !== false) {
                    $data = array_combine($header, $row);
                    
                    Alumni::create([
                        'nama' => $data['nama'] ?? '',
                        'nim' => $data['nim'] ?? null,
                        'prodi' => $data['prodi'] ?? '',
                        'angkatan' => $data['angkatan'] ?? null,
                        'lulusan' => $data['lulusan'] ?? null,
                        'pekerjaan' => $data['pekerjaan'] ?? null,
                        'perusahaan' => $data['perusahaan'] ?? null,
                        'email' => $data['email'] ?? null,
                        'no_hp' => $data['no_hp'] ?? null,
                        'alamat' => $data['alamat'] ?? null,
                        'user_id' => auth()->id(),
                        'status' => 'approved',
                        'approved_by' => auth()->id(),
                        'approved_at' => now(),
                    ]);
                    $imported++;
                }
                fclose($handle);

                return back()->with('success', "Berhasil import $imported data alumni!");
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal import: ' . $e->getMessage());
            }
        }

        // Untuk Excel, butuh package maatwebsite/excel
        // Jika belum install, tampilkan pesan error
        return back()->with('error', 'Untuk import file Excel (.xlsx), please install package: composer require maatwebsite/excel');
    }
}
