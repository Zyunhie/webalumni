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
    return view('welcome');
})->name('welcome');

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

// === CRUD lain ===
Route::get('/alumni', [AlumniController::class, 'index']);
Route::post('/alumni', [AlumniController::class, 'store']);
Route::get('/alumni/{id}', [AlumniController::class, 'show']);
Route::put('/alumni/{id}', [AlumniController::class, 'update']);
Route::delete('/alumni/{id}', [AlumniController::class, 'destroy']);

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
