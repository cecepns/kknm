<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\UserController; 

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
Route::middleware(['guest'])->group(function () {
    Route::get('/register-mahasiswa', [AuthController::class, 'showRegisterMahasiswaForm'])->name('register.mahasiswa');
    Route::post('/register-mahasiswa', [AuthController::class, 'registerMahasiswa']);
    Route::get('/register-dosen', [AuthController::class, 'showRegisterDosenForm'])->name('register.dosen');
    Route::post('/register-dosen', [AuthController::class, 'registerDosen']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/kelola-pengguna-internal', [UserController::class, 'index'])->name('daftar.pengguna.internal');
    Route::get('/kelola-pengguna-internal/form', [UserController::class, 'create'])->name('form.pengguna.internal');
    Route::post('/kelola-pengguna-internal', [UserController::class, 'store'])->name('tambah.pengguna.internal');
    
    // Role Management
    Route::get('/roles', function () {
        return view('admin.roles.index');
    })->name('roles');
    
    // Announcement Management
    Route::get('/announcements', function () {
        return view('admin.announcements.index');
    })->name('announcements');
    
    Route::get('/announcement-access', function () {
        return view('admin.announcements.access');
    })->name('announcement-access');
    
    // FAQ Management
    Route::get('/faq', function () {
        return view('admin.faq.index');
    })->name('faq');
    
    Route::get('/faq-access', function () {
        return view('admin.faq.access');
    })->name('faq-access');
    
    // Knowledge Classification
    Route::get('/knowledge', function () {
        return view('admin.knowledge.index');
    })->name('knowledge');
    
    // Repository Management
    Route::get('/repository', function () {
        return view('admin.repository.index');
    })->name('repository');
    
    Route::get('/public-repository', function () {
        return view('admin.repository.public');
    })->name('public-repository');
    
    // Forum Management
    Route::get('/forum-category', function () {
        return view('admin.forum.category');
    })->name('forum-category');
    
    Route::get('/forum', function () {
        return view('admin.forum.index');
    })->name('forum');
    
    Route::get('/forum-management', function () {
        return view('admin.forum.management');
    })->name('forum-management');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
