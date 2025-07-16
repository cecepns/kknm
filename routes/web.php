<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 

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

Route::middleware(['guest'])->group(function () {
    Route::get('/register-mahasiswa', [AuthController::class, 'showRegisterMahasiswaForm'])->name('register.mahasiswa');
    Route::post('/register-mahasiswa', [AuthController::class, 'registerMahasiswa']);

    Route::get('/register-dosen', [AuthController::class, 'showRegisterDosen'])->name('register.dosen');

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('users');
    
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
