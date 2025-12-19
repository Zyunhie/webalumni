<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\LowonganController;

/*
|--------------------------------------------------------------------------
| PUBLIC AREA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/kontak', 'kontak')->name('kontak');

/*
|--------------------------------------------------------------------------
| ALUMNI STATIC (Sementara)
|--------------------------------------------------------------------------
*/

Route::view('/alumni/data', 'alumni.data')->name('alumni.data');
Route::view('/alumni/testimoni', 'alumni.testimoni')->name('alumni.testimoni');
Route::view('/alumni/agenda', 'alumni.agenda')->name('alumni.agenda');

/*
|--------------------------------------------------------------------------
| ALUMNI S1 (STATIC VIEW – NANTI BISA DIPINDAH KE CONTROLLER)
|--------------------------------------------------------------------------
*/

Route::view('/alumni/s1/pai', 'alumni.s1.pai')->name('alumni.s1.pai');
Route::view('/alumni/s1/piaud', 'alumni.s1.piaud')->name('alumni.s1.piaud');
Route::view('/alumni/s1/mpi', 'alumni.s1.mpi')->name('alumni.s1.mpi');
Route::view('/alumni/s1/bkpi', 'alumni.s1.bkpi')->name('alumni.s1.bkpi');
Route::view('/alumni/s1/eksyar', 'alumni.s1.eksyar')->name('alumni.s1.eksyar');
Route::view('/alumni/s1/as', 'alumni.s1.as')->name('alumni.s1.as');
Route::view('/alumni/s1/htn', 'alumni.s1.htn')->name('alumni.s1.htn');

/*
|--------------------------------------------------------------------------
| ALUMNI S2
|--------------------------------------------------------------------------
*/

Route::view('/alumni/s2/pai', 'alumni.s2.pai')->name('alumni.s2.pai');

/*
|--------------------------------------------------------------------------
| ALUMNI PGMI (USER & ADMIN SATU HALAMAN)
|--------------------------------------------------------------------------
*/

Route::prefix('alumni/s1/pgmi')
    ->name('alumni.s1.pgmi.')
    ->group(function () {

        // LIST (HANYA APPROVED)
        Route::get('/', [AlumniController::class, 'index'])
            ->name('index');

        Route::get('/create', [AlumniController::class, 'create'])
            ->middleware('auth')
            ->name('create');

        Route::post('/', [AlumniController::class, 'store'])
            ->middleware('auth')
            ->name('store');

        Route::get('/{id}', [AlumniController::class, 'show'])
            ->name('show');

        Route::get('/{id}/edit', [AlumniController::class, 'edit'])
            ->middleware('auth')
            ->name('edit');

        Route::put('/{id}', [AlumniController::class, 'update'])
            ->middleware('auth')
            ->name('update');
    });

/*
|--------------------------------------------------------------------------
| BERITA
|--------------------------------------------------------------------------
*/

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

/*
|--------------------------------------------------------------------------
| AGENDA, TESTIMONI, LOWONGAN
|--------------------------------------------------------------------------
*/

Route::get('/agenda', [AgendaController::class, 'index']);
Route::get('/testimoni', [TestimoniController::class, 'index']);
Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
Route::get('/lowongan/{id}', [LowonganController::class, 'show'])->name('lowongan.show');

/*
|--------------------------------------------------------------------------
| AUTH AREA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard.auth');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA (FITUR TAMBAHAN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            abort_if(auth()->user()->role !== 'admin', 403);
            return view('admin.dashboard');
        })->name('dashboard');

        // VERIFIKASI ALUMNI
        Route::get('/alumni/pending', [AlumniController::class, 'pending'])
            ->name('alumni.pending');

        Route::post('/alumni/{id}/approve', [AlumniController::class, 'approve'])
            ->name('alumni.approve');

        Route::post('/alumni/{id}/reject', [AlumniController::class, 'reject'])
            ->name('alumni.reject');
    });

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
