<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\KontakController;

/*
|--------------------------------------------------------------------------
| PUBLIC AREA (READ ONLY)
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Tentang & Kontak
Route::get('/tentang', [AboutController::class, 'index'])->name('tentang');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

/*
|--------------------------------------------------------------------------
| ALUMNI STATIC (PUBLIC)
|--------------------------------------------------------------------------
*/

Route::view('/alumni/data', 'alumni.data')->name('alumni.data');
Route::view('/alumni/testimoni', 'alumni.testimoni')->name('alumni.testimoni');
Route::get('/alumni/agenda', [AgendaController::class, 'index'])->name('alumni.agenda');
Route::get('/alumni/agenda/{agenda}', [AgendaController::class, 'show'])->name('alumni.agenda.show');
Route::get('/alumni/agenda/{agenda}/edit', [AgendaController::class, 'edit'])->name('alumni.agenda.edit')->middleware('auth');
Route::put('/alumni/agenda/{agenda}', [AgendaController::class, 'update'])->name('alumni.agenda.update')->middleware('auth');
Route::delete('/alumni/agenda/{agenda}', [AgendaController::class, 'destroy'])->name('alumni.agenda.destroy')->middleware('auth');
Route::post('/alumni/agenda', [AgendaController::class, 'store'])->name('alumni.agenda.store')->middleware('auth');
Route::delete('/alumni/agenda/destroy-all', [AgendaController::class, 'destroyAll'])->name('agenda.destroyAll')->middleware('auth');

// Testimoni Routes (Unified)
Route::get('/testimoni', [TestimoniController::class, 'index'])->name('testimoni.index');

Route::middleware('auth')->group(function () {
    Route::get('/testimoni/create', [TestimoniController::class, 'create'])->name('testimoni.create');
    Route::post('/testimoni', [TestimoniController::class, 'store'])->name('testimoni.store');
    Route::get('/testimoni/{testimoni}/edit', [TestimoniController::class, 'edit'])->name('testimoni.edit');
    Route::put('/testimoni/{testimoni}', [TestimoniController::class, 'update'])->name('testimoni.update');
    Route::delete('/testimoni/{testimoni}', [TestimoniController::class, 'destroy'])->name('testimoni.destroy');
});

// Admin Testimoni
Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.testimoni.')->group(function () {
    Route::get('/testimoni/pending', [TestimoniController::class, 'adminPending'])->name('pending');
    Route::post('/testimoni/{testimoni}/approve', [TestimoniController::class, 'approve'])->name('approve');
    Route::post('/testimoni/{testimoni}/reject', [TestimoniController::class, 'reject'])->name('reject');
});


/*
|--------------------------------------------------------------------------
| ALUMNI PROGRAM STUDI (DYNAMIC - SEMUA PRODI)
|--------------------------------------------------------------------------
*/

// Rute untuk PGMI (S1)
Route::prefix('alumni/s1/pgmi')
    ->name('alumni.s1.pgmi.')
    ->group(function () {
        Route::get('/', [AlumniController::class, 'index'])->name('index');
        Route::get('/create', [AlumniController::class, 'create'])->name('create');
        Route::post('/', [AlumniController::class, 'store'])->name('store');
        Route::get('/{id}', [AlumniController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AlumniController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AlumniController::class, 'update'])->name('update');
        Route::delete('/{id}', [AlumniController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/upload', [AlumniController::class, 'uploadForm'])->name('upload');
        Route::post('/{id}/upload', [AlumniController::class, 'uploadFile'])->name('upload.store');
    });

// Rute untuk PAI (S1)
Route::prefix('alumni/s1/pai')
    ->name('alumni.s1.pai.')
    ->group(function () {
        Route::get('/', [AlumniController::class, 'index'])->name('index');
        Route::get('/create', [AlumniController::class, 'create'])->name('create');
        Route::post('/', [AlumniController::class, 'store'])->name('store');
        Route::get('/{id}', [AlumniController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AlumniController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AlumniController::class, 'update'])->name('update');
        Route::delete('/{id}', [AlumniController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/upload', [AlumniController::class, 'uploadForm'])->name('upload');
        Route::post('/{id}/upload', [AlumniController::class, 'uploadFile'])->name('upload.store');
    });

// Rute untuk PIAUD (S1)
Route::prefix('alumni/s1/piaud')
    ->name('alumni.s1.piaud.')
    ->group(function () {
        Route::get('/', [AlumniController::class, 'index'])->name('index');
        Route::get('/create', [AlumniController::class, 'create'])->name('create');
        Route::post('/', [AlumniController::class, 'store'])->name('store');
        Route::get('/{id}', [AlumniController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AlumniController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AlumniController::class, 'update'])->name('update');
        Route::delete('/{id}', [AlumniController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/upload', [AlumniController::class, 'uploadForm'])->name('upload');
        Route::post('/{id}/upload', [AlumniController::class, 'uploadFile'])->name('upload.store');
    });

// Rute untuk MPI (S1)
Route::prefix('alumni/s1/mpi')
    ->name('alumni.s1.mpi.')
    ->group(function () {
        Route::get('/', [AlumniController::class, 'index'])->name('index');
        Route::get('/create', [AlumniController::class, 'create'])->name('create');
        Route::post('/', [AlumniController::class, 'store'])->name('store');
        Route::get('/{id}', [AlumniController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AlumniController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AlumniController::class, 'update'])->name('update');
        Route::delete('/{id}', [AlumniController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/upload', [AlumniController::class, 'uploadForm'])->name('upload');
        Route::post('/{id}/upload', [AlumniController::class, 'uploadFile'])->name('upload.store');
    });

// Rute untuk BKPI (S1)
Route::prefix('alumni/s1/bkpi')
    ->name('alumni.s1.bkpi.')
    ->group(function () {
        Route::get('/', [AlumniController::class, 'index'])->name('index');
        Route::get('/create', [AlumniController::class, 'create'])->name('create');
        Route::post('/', [AlumniController::class, 'store'])->name('store');
        Route::get('/{id}', [AlumniController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AlumniController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AlumniController::class, 'update'])->name('update');
        Route::delete('/{id}', [AlumniController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/upload', [AlumniController::class, 'uploadForm'])->name('upload');
        Route::post('/{id}/upload', [AlumniController::class, 'uploadFile'])->name('upload.store');
    });

// Rute untuk EKSYAR (S1)
Route::prefix('alumni/s1/eksyar')
    ->name('alumni.s1.eksyar.')
    ->group(function () {
        Route::get('/', [AlumniController::class, 'index'])->name('index');
        Route::get('/create', [AlumniController::class, 'create'])->name('create');
        Route::post('/', [AlumniController::class, 'store'])->name('store');
        Route::get('/{id}', [AlumniController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AlumniController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AlumniController::class, 'update'])->name('update');
        Route::delete('/{id}', [AlumniController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/upload', [AlumniController::class, 'uploadForm'])->name('upload');
        Route::post('/{id}/upload', [AlumniController::class, 'uploadFile'])->name('upload.store');
    });

// Rute untuk AS (Hukum Keluarga Islam) (S1)
Route::prefix('alumni/s1/as')
    ->name('alumni.s1.as.')
    ->group(function () {
        Route::get('/', [AlumniController::class, 'index'])->name('index');
        Route::get('/create', [AlumniController::class, 'create'])->name('create');
        Route::post('/', [AlumniController::class, 'store'])->name('store');
        Route::get('/{id}', [AlumniController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AlumniController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AlumniController::class, 'update'])->name('update');
        Route::delete('/{id}', [AlumniController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/upload', [AlumniController::class, 'uploadForm'])->name('upload');
        Route::post('/{id}/upload', [AlumniController::class, 'uploadFile'])->name('upload.store');
    });

// Rute untuk HTN (Hukum Tata Negara) (S1)
Route::prefix('alumni/s1/htn')
    ->name('alumni.s1.htn.')
    ->group(function () {
        Route::get('/', [AlumniController::class, 'index'])->name('index');
        Route::get('/create', [AlumniController::class, 'create'])->name('create');
        Route::post('/', [AlumniController::class, 'store'])->name('store');
        Route::get('/{id}', [AlumniController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AlumniController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AlumniController::class, 'update'])->name('update');
        Route::delete('/{id}', [AlumniController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/upload', [AlumniController::class, 'uploadForm'])->name('upload');
        Route::post('/{id}/upload', [AlumniController::class, 'uploadFile'])->name('upload.store');
    });

// Rute untuk S2 PAI
Route::prefix('alumni/s2/pai')
    ->name('alumni.s2.pai.')
    ->group(function () {
        Route::get('/', [AlumniController::class, 'index'])->name('index');
        Route::get('/create', [AlumniController::class, 'create'])->name('create');
        Route::post('/', [AlumniController::class, 'store'])->name('store');
        Route::get('/{id}', [AlumniController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AlumniController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AlumniController::class, 'update'])->name('update');
        Route::delete('/{id}', [AlumniController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/upload', [AlumniController::class, 'uploadForm'])->name('upload');
        Route::post('/{id}/upload', [AlumniController::class, 'uploadFile'])->name('upload.store');
    });

/*
|--------------------------------------------------------------------------
| ALUMNI UMUM (CREATE - TANPA PRODI SPESIFIK)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/alumni/create', [AlumniController::class, 'create'])->name('alumni.create');
    Route::post('/alumni', [AlumniController::class, 'store'])->name('alumni.store');
});

/*
|--------------------------------------------------------------------------
| BERITA / AGENDA / TESTIMONI / LOWONGAN
|--------------------------------------------------------------------------
*/

// Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

// Agenda
Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');

// Lowongan
Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
Route::get('/lowongan/{lowongan}', [LowonganController::class, 'show'])->name('lowongan.show');
Route::post('/lowongan/{lowongan}/lamar', [LowonganController::class, 'lamar'])->middleware('auth')->name('lowongan.lamar');
Route::get('/dashboard/lowongan', [LowonganController::class, 'dashboard'])->middleware('auth')->name('lowongan.dashboard');


/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER AREA (ALUMNI + ADMIN)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [AlumniController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA (ROLE: ADMIN ONLY)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
        // Dashboard admin
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        // Alumni approval
        Route::get('/alumni/pending', [AlumniController::class, 'pending'])
            ->name('alumni.pending');

        Route::post('/alumni/{id}/approve', [AlumniController::class, 'approve'])
            ->name('alumni.approve');

        Route::post('/alumni/{id}/reject', [AlumniController::class, 'reject'])
            ->name('alumni.reject');

        // Import/Export Alumni
        Route::post('/alumni/import', [AlumniController::class, 'import'])
            ->name('alumni.import');

        Route::get('/alumni/template', [AlumniController::class, 'downloadTemplate'])
            ->name('alumni.template');

        // User Management
        Route::resource('/users', UserController::class);

        // Berita Admin CRUD
        Route::get('berita', [BeritaController::class, 'adminIndex'])->name('berita.index');
        Route::get('berita/create', [BeritaController::class, 'create'])->name('berita.create');
        Route::post('berita', [BeritaController::class, 'store'])->name('berita.store');
        Route::get('berita/{berita}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
        Route::put('berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
        Route::delete('berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');

        // Tentang Admin
        Route::post('/tentang/update-text', [AboutController::class, 'updateText'])
            ->name('tentang.update.text');
        Route::post('/tentang/update-image', [AboutController::class, 'updateImage'])
            ->name('tentang.update.image');
        
        // Lowongan Kerja Admin
        Route::resource('lowongan', \App\Http\Controllers\Admin\LowonganController::class)->except(['destroy']);
        Route::post('lowongan/{lowongan}/approve', [\App\Http\Controllers\Admin\LowonganController::class, 'approve'])->name('lowongan.approve');
        Route::post('lowongan/{lowongan}/reject', [\App\Http\Controllers\Admin\LowonganController::class, 'reject'])->name('lowongan.reject');
        Route::post('lowongan/{lowongan}/notify', [\App\Http\Controllers\Admin\LowonganController::class, 'sendNotification'])->name('lowongan.notify');

        // Kelola Pesan Kontak
        Route::get('/kontak', [KontakController::class, 'adminIndex'])->name('kontak.index');
        Route::post('/kontak/{pesan}/read', [KontakController::class, 'markAsRead'])->name('kontak.read');
        Route::delete('/kontak/{pesan}', [KontakController::class, 'destroy'])->name('kontak.destroy');
        Route::post('/kontak/mark-all-read', [KontakController::class, 'markAllAsRead'])->name('kontak.markAllRead');
    });


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

