<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\UserController; 
use App\Http\Controllers\FaqController;
use App\Http\Controllers\AnnouncementController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::redirect('/', '/dashboard');

// Rute untuk pengguna yang belum terotentikasi (tamu)
Route::middleware(['guest'])->group(function () {
    // Rute Pendaftaran
    Route::get('/register-mahasiswa', [AuthController::class, 'showRegisterMahasiswaForm'])->name('register.mahasiswa');
    Route::post('/register-mahasiswa', [AuthController::class, 'registerMahasiswa']);
    Route::get('/register-dosen', [AuthController::class, 'showRegisterDosenForm'])->name('register.dosen');
    Route::post('/register-dosen', [AuthController::class, 'registerDosen']);

    // Rute Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rute untuk pengguna yang sudah terotentikasi
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Akses FAQ (memerlukan login)
    Route::get('/akses-faq', [FaqController::class, 'publicIndex'])->name('akses.faq');

    // Kelola Pengguna Internal (CRUD)
    Route::get('/kelola-pengguna-internal', [UserController::class, 'index'])->name('daftar.pengguna.internal');
    Route::get('/kelola-pengguna-internal/tambah', [UserController::class, 'create'])->name('form.tambah.pengguna.internal');
    Route::post('/kelola-pengguna-internal', [UserController::class, 'store'])->name('tambah.pengguna.internal');
    Route::get('/kelola-pengguna-internal/{user}/edit', [UserController::class, 'edit'])->name('form.edit.pengguna.internal');
    Route::put('/kelola-pengguna-internal/{user}', [UserController::class, 'update'])->name('edit.pengguna.internal');
    Route::delete('/kelola-pengguna-internal/{user}', [UserController::class, 'destroy'])->name('hapus.pengguna.internal');
    
    // Kelola FAQ (CRUD)
    Route::get('/kelola-faq', [FaqController::class, 'index'])->name('daftar.kelola.faq');
    Route::get('/kelola-faq/tambah', [FaqController::class, 'create'])->name('form.tambah.kelola.faq');
    Route::post('/kelola-faq', [FaqController::class, 'store'])->name('tambah.kelola.faq');
    Route::get('/kelola-faq/{faq}/edit', [FaqController::class, 'edit'])->name('form.edit.kelola.faq');
    Route::put('/kelola-faq/{faq}', [FaqController::class, 'update'])->name('edit.kelola.faq');
    Route::delete('/kelola-faq/{faq}', [FaqController::class, 'destroy'])->name('hapus.kelola.faq');

    // Kelola Pengumuman (CRUD)
    Route::get('/kelola-pengumuman', [AnnouncementController::class, 'index'])->name('daftar.kelola.pengumuman');
    Route::get('/kelola-pengumuman/tambah', [AnnouncementController::class, 'create'])->name('form.tambah.kelola.pengumuman');
    Route::post('/kelola-pengumuman', [AnnouncementController::class, 'store'])->name('tambah.kelola.pengumuman');
    Route::get('/kelola-pengumuman/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('form.edit.kelola.pengumuman');
    Route::put('/kelola-pengumuman/{announcement}', [AnnouncementController::class, 'update'])->name('edit.kelola.pengumuman');
    Route::delete('/kelola-pengumuman/{announcement}', [AnnouncementController::class, 'destroy'])->name('hapus.kelola.pengumuman');
    
    // Akses Pengumuman (View Only)
    Route::get('/akses-pengumuman', [AnnouncementController::class, 'publicIndex'])->name('akses.pengumuman');
    Route::get('/akses-pengumuman/{id}', [AnnouncementController::class, 'publicShow'])->name('akses.pengumuman.detail');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
