<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\LowonganController;
use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Halaman statis
Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

Route::get('/kontak', function () {
    return view('kontak');
})->name('kontak');

// Halaman Alumni (statis)
Route::get('/alumni/data', function () {
    return view('alumni.data');
})->name('alumni.data');

Route::get('/alumni/testimoni', function () {
    return view('alumni.testimoni');
})->name('alumni.testimoni');

Route::get('/alumni/agenda', function () {
    return view('alumni.agenda');
})->name('alumni.agenda');

// === ROUTE PER PRODI ===
// S1
Route::get('/alumni/s1/pai', function () {
    return view('alumni.s1.pai');
})->name('alumni.s1.pai');

// === ALUMNI PGMI ===
Route::get('/alumni/s1/pgmi', [AlumniController::class, 'pgmiIndex'])->name('alumni.s1.pgmi');
Route::prefix('alumni/s1/pgmi')->name('alumni.s1.pgmi.')->group(function () {
    Route::get('/', [AlumniController::class, 'pgmiIndex'])->name('');
    Route::get('/create', [AlumniController::class, 'pgmiCreate'])->name('create');
    Route::post('/store', [AlumniController::class, 'pgmiStore'])->name('store');
    Route::get('/{id}', [AlumniController::class, 'pgmiShow'])->name('show');
});

Route::get('/alumni/s1/piaud', function () {
    return view('alumni.s1.piaud');
})->name('alumni.s1.piaud');

Route::get('/alumni/s1/mpi', function () {
    return view('alumni.s1.mpi');
})->name('alumni.s1.mpi');

Route::get('/alumni/s1/bkpi', function () {
    return view('alumni.s1.bkpi');
})->name('alumni.s1.bkpi');

Route::get('/alumni/s1/eksyar', function () {
    return view('alumni.s1.eksyar');
})->name('alumni.s1.eksyar');

Route::get('/alumni/s1/as', function () {
    return view('alumni.s1.as');
})->name('alumni.s1.as');

Route::get('/alumni/s1/htn', function () {
    return view('alumni.s1.htn');
})->name('alumni.s1.htn');

// S2
Route::get('/alumni/s2/pai', function () {
    return view('alumni.s2.pai');
})->name('alumni.s2.pai');

// === CRUD + Tampilan Berita ===
Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
Route::post('/berita', [BeritaController::class, 'store']);
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');
Route::put('/berita/{id}', [BeritaController::class, 'update']);
Route::delete('/berita/{id}', [BeritaController::class, 'destroy']);

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Login
Route::get('/login', function () {
    return view('login');
})->name('login');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/testimoni', [TestimoniController::class, 'index']);
Route::post('/testimoni', [TestimoniController::class, 'store']);
Route::get('/testimoni/{id}', [TestimoniController::class, 'show']);
Route::put('/testimoni/{id}', [TestimoniController::class, 'update']);
Route::delete('/testimoni/{id}', [TestimoniController::class, 'destroy']);

Route::get('/agenda', [AgendaController::class, 'index']);
Route::post('/agenda', [AgendaController::class, 'store']);
Route::get('/agenda/{id}', [AgendaController::class, 'show']);
Route::put('/agenda/{id}', [AgendaController::class, 'update']);
Route::delete('/agenda/{id}', [AgendaController::class, 'destroy']);

Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
Route::post('/lowongan', [LowonganController::class, 'store']);
Route::get('/lowongan/{id}', [LowonganController::class, 'show'])->name('lowongan.show');
Route::put('/lowongan/{id}', [LowonganController::class, 'update']);
Route::delete('/lowongan/{id}', [LowonganController::class, 'destroy']);

require __DIR__.'/auth.php';
