<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\UserController; 
use App\Http\Controllers\FaqController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ForumCategoryController;
use App\Http\Controllers\ForumDiscussionController;


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
    
    // Kelola Kategori Forum (CRUD)
    Route::get('/kelola-kategori-forum', [ForumCategoryController::class, 'index'])->name('daftar.kelola.kategori.forum');
    Route::get('/kelola-kategori-forum/tambah', [ForumCategoryController::class, 'create'])->name('form.tambah.kelola.kategori.forum');
    Route::post('/kelola-kategori-forum', [ForumCategoryController::class, 'store'])->name('tambah.kelola.kategori.forum');
    Route::get('/kelola-kategori-forum/{forumCategory}/edit', [ForumCategoryController::class, 'edit'])->name('form.edit.kelola.kategori.forum');
    Route::put('/kelola-kategori-forum/{forumCategory}', [ForumCategoryController::class, 'update'])->name('edit.kelola.kategori.forum');
    Route::delete('/kelola-kategori-forum/{forumCategory}', [ForumCategoryController::class, 'destroy'])->name('hapus.kelola.kategori.forum');
    
    // Forum Diskusi (CRUD)
    Route::get('/forum-diskusi', [ForumDiscussionController::class, 'index'])->name('forum.diskusi');
    Route::get('/forum-diskusi/tambah', [ForumDiscussionController::class, 'create'])->name('form.tambah.forum.diskusi');
    Route::post('/forum-diskusi', [ForumDiscussionController::class, 'store'])->name('tambah.forum.diskusi');
    Route::get('/forum-diskusi/{id}', [ForumDiscussionController::class, 'show'])->name('forum.diskusi.detail');
    Route::post('/forum-diskusi/{id}/komentar', [ForumDiscussionController::class, 'storeComment'])->name('tambah.komentar');
    Route::get('/forum-diskusi/{id}/edit', [ForumDiscussionController::class, 'edit'])->name('form.edit.forum.diskusi');
    Route::put('/forum-diskusi/{id}', [ForumDiscussionController::class, 'update'])->name('edit.forum.diskusi');
    Route::delete('/forum-diskusi/{id}', [ForumDiscussionController::class, 'destroy'])->name('hapus.forum.diskusi');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
