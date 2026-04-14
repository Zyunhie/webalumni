<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AlumniController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('role:admin')->only(['pending', 'approve', 'reject']);
    }

    /**
     * INDEX - Tampilkan semua alumni (tanpa filter status) untuk user login
     * Untuk guest, hanya tampilkan yang approved.
     */
    public function index(Request $request)
{
    // Deteksi prodi dari route name
    $prodi = null;
    $routeName = $request->route()->getName();
    $prodiMapping = [
        'alumni.s1.pgmi' => 'PGMI',
        'alumni.s1.pai'  => 'PAI',
        'alumni.s1.piaud'=> 'PIAUD',
        'alumni.s1.mpi'  => 'MPI',
        'alumni.s1.bkpi' => 'BKPI',
        'alumni.s1.eksyar'=> 'EKSYAR',
        'alumni.s1.as'   => 'AS',
        'alumni.s1.htn'  => 'HTN',
        'alumni.s2.pai'  => 'PAI (S2)',
    ];
    foreach ($prodiMapping as $routeKey => $prodiName) {
        if (str_contains($routeName, $routeKey)) {
            $prodi = $prodiName;
            break;
        }
    }

    $query = Alumni::query();

    // Jika mode pending dan user bukan admin, redirect ke index normal
    if ($request->get('mode') === 'pending') {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            // DEBUG: Auth lost on toggle - check logs
            Log::info('ALUMNI TOGGLE DEBUG', [
                'auth_check' => auth()->check(),
                'user_id' => auth()->id(),
                'role' => auth()->user()?->role ?? 'no user',
                'session_id' => session()->getId(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip()
            ]);
            return redirect()->route($this->getProdiRoute($prodi ?? 'PGMI') . '.index', 
                $request->except('mode'));
        }
    }

    // Guest hanya lihat approved
    if (!auth()->check()) {
        $query->where('status', 'approved');
    }

    // Filter prodi dari route
    if ($prodi) {
    $query->where('prodi', $prodi);
    }

    // Filter dari request (prodi dari link, angkatan)
    if ($request->filled('prodi')) {
        $query->where('prodi', $request->prodi);
    }
    if ($request->filled('angkatan') && $request->angkatan !== 'all') {
        $query->where('angkatan', $request->angkatan);
    }

    // Mode pending untuk admin
    if ($request->get('mode') === 'pending' && auth()->check() && auth()->user()->role === 'admin') {
        $query->where('status', 'pending');
    }

    $alumni = $query->latest()->paginate(20);

    // AJAX partial for toggle
    if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
        return view('alumni.partials.table', compact('alumni', 'routePrefix'));
    }

    $angkatanList = Alumni::distinct()->orderBy('angkatan', 'desc')->pluck('angkatan');
    $routePrefix = $this->getProdiRoute($prodi ?? 'PGMI');

    return view('alumni.index', compact('alumni', 'angkatanList', 'prodi', 'routePrefix'));
}

    /**
     * CREATE - Form tambah data
     */
    public function create(Request $request)
    {
        $routeName = $request->route()->getName();
        $selectedProdi = null;
        
        $prodiMapping = [
            'alumni.s1.pgmi' => 'PGMI',
            'alumni.s1.pai' => 'PAI',
            'alumni.s1.piaud' => 'PIAUD',
            'alumni.s1.mpi' => 'MPI',
            'alumni.s1.bkpi' => 'BKPI',
            'alumni.s1.eksyar' => 'EKSYAR',
            'alumni.s1.as' => 'AS',
            'alumni.s1.htn' => 'HTN',
            'alumni.s2.pai' => 'PAI (S2)',
        ];
        
        foreach ($prodiMapping as $routeKey => $prodiName) {
            if (str_contains($routeName, $routeKey)) {
                $selectedProdi = $prodiName;
                break;
            }
        }

        // Jika admin, ambil daftar user untuk dipilih (opsional)
        $users = [];
        if (auth()->user()->role === 'admin') {
            $users = User::where('role', '!=', 'admin')->orWhere('role', 'alumni')->get();
        }

        return view('alumni.create', compact('selectedProdi', 'users'));
    }

    /**
     * STORE - Simpan data baru
     * Jika admin: bisa pilih user_id, jika tidak diisi maka buat user baru
     * Jika user biasa: pakai auth()->id()
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
            'user_id'    => 'nullable|exists:users,id', // khusus admin
        ]);

        $data = $request->except(['foto', 'ijazah', 'transkrip', 'user_id']);

        // Penentuan user_id
        if (auth()->user()->role === 'admin') {
            if ($request->filled('user_id')) {
                // Admin pilih user yang sudah ada
                $data['user_id'] = $request->user_id;
            } else {
                // Admin tidak pilih user_id → buat user baru
$user = User::create([
    'name'     => $request->nama,
    'email'    => $request->email ?? ($request->nim ? $request->nim . '@alumni.temp.com' : Str::random(10) . '@temp.com'),
    'password' => $request->nim ? Hash::make($request->nim) : Hash::make(Str::random(8)),
    'role'     => 'alumni',
    'nim'      => $request->nim,
]);
                $data['user_id'] = $user->id;
            }
            $data['status'] = 'approved';
            $data['approved_by'] = auth()->id();
            $data['approved_at'] = now();
        } else {
            // User biasa: langsung pakai user_id nya sendiri
            $data['user_id'] = auth()->id();
            $data['status'] = 'pending';
        }

        // Upload file
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

        $redirectRoute = $this->getProdiRoute($request->prodi);
        $message = (auth()->user()->role === 'admin') 
            ? 'Data alumni berhasil ditambahkan (approved).' 
            : 'Data berhasil dikirim dan menunggu persetujuan admin.';

        return redirect()->route($redirectRoute . '.index')->with('success', $message);
    }

    /**
     * SHOW - Detail alumni (dengan proteksi)
     */
    public function show($id)
    {
        $alumni = Alumni::findOrFail($id);

        if ($alumni->status !== 'approved' && 
            auth()->check() && 
            auth()->user()->role !== 'admin' && 
            $alumni->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak mengakses data ini.');
        }

        $routePrefix = $this->getProdiRoute($alumni->prodi);
        return view('alumni.show', compact('alumni', 'routePrefix'));
    }

    /**
     * EDIT - Form edit (dengan proteksi)
     */
    public function edit($id)
    {
        $alumni = Alumni::findOrFail($id);

        if (auth()->user()->role != 'admin' && $alumni->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $routePrefix = $this->getProdiRoute($alumni->prodi);
        return view('alumni.edit', compact('alumni', 'routePrefix'));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, $id)
{
    $alumni = Alumni::findOrFail($id);

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

    // Jika admin, langsung update tanpa pending
    if (auth()->user()->role == 'admin') {
        $data = $request->except(['_token', '_method', 'foto', 'ijazah', 'transkrip']);
        // handle file upload langsung (sama seperti kode admin sebelumnya)
        if ($request->hasFile('foto')) {
            if ($alumni->foto) Storage::disk('public')->delete($alumni->foto);
            $data['foto'] = $request->file('foto')->store('foto_alumni', 'public');
        }
        if ($request->hasFile('ijazah')) {
            if ($alumni->ijazah) Storage::disk('public')->delete($alumni->ijazah);
            $data['ijazah'] = $request->file('ijazah')->store('ijazah', 'public');
        }
        if ($request->hasFile('transkrip')) {
            if ($alumni->transkrip) Storage::disk('public')->delete($alumni->transkrip);
            $data['transkrip'] = $request->file('transkrip')->store('transkrip', 'public');
        }
        $alumni->update($data);
        return redirect()->route($this->getProdiRoute($alumni->prodi) . '.show', $alumni->id)
            ->with('success', 'Data berhasil diperbarui (oleh admin).');
    }

    // Jika bukan admin (yaitu pemilik data), simpan perubahan ke pending_data
    $pendingData = $request->except(['_token', '_method', 'foto', 'ijazah', 'transkrip']);
    
    // Upload file sementara ke folder pending_*
    if ($request->hasFile('foto')) {
        $pendingData['foto'] = $request->file('foto')->store('pending_foto', 'public');
    }
    if ($request->hasFile('ijazah')) {
        $pendingData['ijazah'] = $request->file('ijazah')->store('pending_ijazah', 'public');
    }
    if ($request->hasFile('transkrip')) {
        $pendingData['transkrip'] = $request->file('transkrip')->store('pending_transkrip', 'public');
    }

    $alumni->update([
        'status' => 'pending',
        'pending_data' => json_encode($pendingData),
        'rejection_reason' => null,
    ]);

    return redirect()->route($this->getProdiRoute($alumni->prodi) . '.show', $alumni->id)
        ->with('success', 'Perubahan disimpan dan menunggu persetujuan admin.');
}

    /**
     * DESTROY
     */
    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);

        if (auth()->user()->role != 'admin' && $alumni->user_id !== auth()->id()) {
            abort(403);
        }

        if ($alumni->foto) Storage::disk('public')->delete($alumni->foto);
        if ($alumni->ijazah) Storage::disk('public')->delete($alumni->ijazah);
        if ($alumni->transkrip) Storage::disk('public')->delete($alumni->transkrip);

        $alumni->delete();

        $routePrefix = $this->getProdiRoute($alumni->prodi);
        return redirect()->route($routePrefix . '.index')
            ->with('success', 'Data alumni berhasil dihapus.');
    }

    /**
     * UPLOAD FORM (khusus untuk alumni sendiri)
     */
    public function uploadForm($id)
    {
        $alumni = Alumni::findOrFail($id);

        if ($alumni->user_id != auth()->id()) {
            abort(403, 'Anda hanya bisa mengupload dokumen untuk data Anda sendiri.');
        }

        $routePrefix = $this->getProdiRoute($alumni->prodi);
        return view('alumni.upload', compact('alumni', 'routePrefix'));
    }

    /**
     * UPLOAD FILE
     */
    public function uploadFile(Request $request, $id)
{
    $alumni = Alumni::findOrFail($id);

    if ($alumni->user_id != auth()->id()) {
        abort(403);
    }

    $request->validate([
        'ijazah'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'transkrip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
    ]);

    // Jika admin, langsung upload ke kolom utama
    if (auth()->user()->role == 'admin') {
        if ($request->hasFile('ijazah')) {
            if ($alumni->ijazah) Storage::disk('public')->delete($alumni->ijazah);
            $alumni->ijazah = $request->file('ijazah')->store('ijazah', 'public');
        }
        if ($request->hasFile('transkrip')) {
            if ($alumni->transkrip) Storage::disk('public')->delete($alumni->transkrip);
            $alumni->transkrip = $request->file('transkrip')->store('transkrip', 'public');
        }
        $alumni->save();
        return redirect()->route($this->getProdiRoute($alumni->prodi) . '.show', $alumni->id)
            ->with('success', 'Dokumen berhasil diupload.');
    }

    // Jika alumni sendiri, simpan ke pending_data
    $pendingData = $alumni->pending_data ? json_decode($alumni->pending_data, true) : [];
    if ($request->hasFile('ijazah')) {
        $pendingData['ijazah'] = $request->file('ijazah')->store('pending_ijazah', 'public');
    }
    if ($request->hasFile('transkrip')) {
        $pendingData['transkrip'] = $request->file('transkrip')->store('pending_transkrip', 'public');
    }

    $alumni->update([
        'status' => 'pending',
        'pending_data' => json_encode($pendingData),
        'rejection_reason' => null,
    ]);

    return redirect()->route($this->getProdiRoute($alumni->prodi) . '.show', $alumni->id)
        ->with('success', 'Dokumen diupload, menunggu persetujuan admin.');
}

    /**
     * PROFILE - milik sendiri
     */
    public function profile()
    {
        $user = auth()->user();
        $alumni = Alumni::where('user_id', $user->id)->get();
        return view('alumni.profile', compact('alumni'));
    }

    /**
     * ADMIN: PENDING LIST
     */
    public function pending()
    {
        $alumni = Alumni::where('status', 'pending')->with('user')->latest()->get();
        return view('admin.alumni.pending', compact('alumni'));
    }

    public function approve($id)
{
    $alumni = Alumni::findOrFail($id);
    $pending = $alumni->pending_data ? json_decode($alumni->pending_data, true) : [];

    if (!empty($pending)) {
        // Pindahkan file dari pending_* ke folder permanen jika ada
        if (isset($pending['foto']) && file_exists(storage_path('app/public/' . $pending['foto']))) {
            // Hapus foto lama jika ada
            if ($alumni->foto) Storage::disk('public')->delete($alumni->foto);
            // Pindahkan file (rename) ke folder permanen
            $newPath = 'foto_alumni/' . basename($pending['foto']);
            Storage::disk('public')->move($pending['foto'], $newPath);
            $pending['foto'] = $newPath;
        }
        if (isset($pending['ijazah']) && file_exists(storage_path('app/public/' . $pending['ijazah']))) {
            if ($alumni->ijazah) Storage::disk('public')->delete($alumni->ijazah);
            $newPath = 'ijazah/' . basename($pending['ijazah']);
            Storage::disk('public')->move($pending['ijazah'], $newPath);
            $pending['ijazah'] = $newPath;
        }
        if (isset($pending['transkrip']) && file_exists(storage_path('app/public/' . $pending['transkrip']))) {
            if ($alumni->transkrip) Storage::disk('public')->delete($alumni->transkrip);
            $newPath = 'transkrip/' . basename($pending['transkrip']);
            Storage::disk('public')->move($pending['transkrip'], $newPath);
            $pending['transkrip'] = $newPath;
        }

        // Terapkan perubahan ke kolom utama
        $alumni->update(array_merge($pending, [
            'status' => 'approved',
            'pending_data' => null,
            'rejection_reason' => null,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]));
    } else {
        // Jika tidak ada pending_data, hanya ubah status
        $alumni->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
    }

    return back()->with('success', 'Perubahan disetujui.');
}

    public function reject(Request $request, $id)
{
    $request->validate(['reason' => 'required|string|max:1000']);
    $alumni = Alumni::findOrFail($id);

    // Hapus file-file pending jika ada
    if ($alumni->pending_data) {
        $pending = json_decode($alumni->pending_data, true) ?: [];
        foreach (['foto', 'ijazah', 'transkrip'] as $field) {
            if (isset($pending[$field]) && Storage::disk('public')->exists($pending[$field])) {
                Storage::disk('public')->delete($pending[$field]);
            }
        }
    }

    $updateData = [
        'status' => 'rejected',
        'rejection_reason' => $request->reason,
        'pending_data' => null,
    ];

    $alumni->update($updateData);

    Log::info('REJECT DEBUG', [
        'alumni_id' => $id,
        'reason' => $request->reason,
        'updated' => $alumni->fresh()->only(['status', 'rejection_reason'])
    ]);

    return back()->with('error', 'Perubahan ditolak. Alasan: ' . $request->reason);
}

    /**
     * IMPORT CSV (otomatis buat user)
     */
    public function import(Request $request)
{
    $request->validate(['file' => 'required|file|mimes:csv,txt|max:5120']);

    $file = $request->file('file');
    $path = $file->getRealPath();
    $content = file_get_contents($path);

    // Hapus BOM
    if (substr($content, 0, 3) == "\xEF\xBB\xBF") {
        $content = substr($content, 3);
    }

    // Deteksi delimiter
    $firstLine = strtok($content, "\n");
    $delimiters = [',', ';', "\t"];
    $bestDelimiter = ',';
    $maxCount = 0;
    foreach ($delimiters as $delim) {
        $count = substr_count($firstLine, $delim);
        if ($count > $maxCount) {
            $maxCount = $count;
            $bestDelimiter = $delim;
        }
    }
    $delimiter = $bestDelimiter;

    // Baca CSV
    $rows = array_map(function($line) use ($delimiter) {
        return str_getcsv($line, $delimiter);
    }, explode("\n", $content));

    if (count($rows) < 2) {
        return back()->with('error', 'File CSV tidak memiliki data atau header.');
    }

    $header = array_shift($rows);
    $header = array_map('trim', $header);

    // Cari index kolom yang diperlukan
    $namaIndex = array_search('nama', array_map('strtolower', $header));
    $prodiIndex = array_search('prodi', array_map('strtolower', $header));
    $nimIndex = array_search('nim', array_map('strtolower', $header));
    $emailIndex = array_search('email', array_map('strtolower', $header));
    $angkatanIndex = array_search('angkatan', array_map('strtolower', $header));
    $lulusanIndex = array_search('lulusan', array_map('strtolower', $header));
    $pekerjaanIndex = array_search('pekerjaan', array_map('strtolower', $header));
    $perusahaanIndex = array_search('perusahaan', array_map('strtolower', $header));
    $no_hpIndex = array_search('no_hp', array_map('strtolower', $header));
    $alamatIndex = array_search('alamat', array_map('strtolower', $header));

    if ($namaIndex === false || $prodiIndex === false) {
        return back()->with('error', 'Header harus mengandung kolom "nama" dan "prodi". Header: ' . implode(',', $header));
    }

    $imported = 0;
    $errors = [];

    foreach ($rows as $rowNum => $row) {
        if (count($row) < count($header)) continue;
        if (empty(array_filter($row))) continue;

        $nama = trim($row[$namaIndex] ?? '');
        $prodi = trim($row[$prodiIndex] ?? '');
        if (empty($nama) || empty($prodi)) {
            $errors[] = "Baris " . ($rowNum+2) . ": Nama atau Prodi kosong";
            continue;
        }

        $nim = $nimIndex !== false ? trim($row[$nimIndex] ?? '') : null;
        $email = $emailIndex !== false ? trim($row[$emailIndex] ?? '') : null;
        $angkatan = $angkatanIndex !== false ? trim($row[$angkatanIndex] ?? '') : null;
        $lulusan = $lulusanIndex !== false ? trim($row[$lulusanIndex] ?? '') : null;
        $pekerjaan = $pekerjaanIndex !== false ? trim($row[$pekerjaanIndex] ?? '') : null;
        $perusahaan = $perusahaanIndex !== false ? trim($row[$perusahaanIndex] ?? '') : null;
        $no_hp = $no_hpIndex !== false ? trim($row[$no_hpIndex] ?? '') : null;
        $alamat = $alamatIndex !== false ? trim($row[$alamatIndex] ?? '') : null;

        // Cari atau buat user
        $user = null;
        if ($email) {
            $user = User::where('email', $email)->first();
        }
        if (!$user && $nim) {
            $user = User::where('nim', $nim)->first();
        }

        if (!$user) {
            try {
                $user = User::create([
                    'name' => $nama,
                    'email' => $email ?? ($nim ? $nim . '@alumni.import.com' : \Illuminate\Support\Str::random(10) . '@temp.com'),
                    'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                    'role' => 'alumni',
                    'nim' => $nim,
                ]);
            } catch (\Exception $e) {
                $errors[] = "Baris " . ($rowNum+2) . ": Gagal buat user - " . $e->getMessage();
                continue;
            }
        }

        // Buat alumni
        try {
            Alumni::create([
                'nama' => $nama,
                'nim' => $nim,
                'prodi' => $prodi,
                'angkatan' => $angkatan ?: null,
                'lulusan' => $lulusan ?: null,
                'pekerjaan' => $pekerjaan,
                'perusahaan' => $perusahaan,
                'email' => $email,
                'no_hp' => $no_hp,
                'alamat' => $alamat,
                'user_id' => $user->id,
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
            $imported++;
        } catch (\Exception $e) {
            $errors[] = "Baris " . ($rowNum+2) . ": Gagal simpan alumni - " . $e->getMessage();
        }
    }

    $msg = "Berhasil import $imported data.";
    if (!empty($errors)) {
        $msg .= " Error: " . implode('; ', $errors);
        return back()->with('warning', $msg);
    }
    return back()->with('success', $msg);
}

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_alumni.csv"',
        ];

        $callback = function() {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['nama', 'nim', 'prodi', 'angkatan', 'lulusan', 'pekerjaan', 'perusahaan', 'email', 'no_hp', 'alamat']);
            fputcsv($handle, ['Contoh Nama', '123456789', 'PGMI', '2020', '2024', 'Guru', 'SDN 1', 'contoh@email.com', '081234567890', 'Jl. Contoh']);
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Helper: get route prefix based on prodi
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
}