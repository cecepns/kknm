<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\UserController; 
use App\Http\Controllers\FaqController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ForumCategoryController;
use App\Http\Controllers\ForumDiscussionController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\KnowledgeCategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;


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

// ANCHOR: Redirect root to login for unauthenticated users, dashboard for authenticated users
Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
})->name('home');


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

    // Rute Forgot Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Rute untuk pengguna yang sudah terotentikasi
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Utility Demo (for development)
    Route::get('/utility-demo', [DashboardController::class, 'utilityDemo'])->name('utility.demo');

    // Monitoring Aktivitas - Admin only
    Route::middleware(['permission:monitoring-aktifitas'])->group(function () {
        Route::get('/monitoring-aktifitas', [ActivityController::class, 'index'])->name('monitoring.aktifitas');
    });

    // Akses FAQ (memerlukan permission akses-faq)
    Route::middleware(['permission:akses-faq'])->group(function () {
        Route::get('/akses-faq', [FaqController::class, 'publicIndex'])->name('akses.faq');
    });

    // Kelola Pengguna Internal (CRUD) - Admin only
    Route::middleware(['permission:kelola-pengguna-internal'])->group(function () {
        Route::get('/kelola-pengguna-internal', [UserController::class, 'index'])->name('daftar.pengguna.internal');
        Route::get('/kelola-pengguna-internal/tambah', [UserController::class, 'create'])->name('form.tambah.pengguna.internal');
        Route::post('/kelola-pengguna-internal', [UserController::class, 'store'])->name('tambah.pengguna.internal');
        Route::get('/kelola-pengguna-internal/{user}/edit', [UserController::class, 'edit'])->name('form.edit.pengguna.internal');
        Route::put('/kelola-pengguna-internal/{user}', [UserController::class, 'update'])->name('edit.pengguna.internal');
        Route::delete('/kelola-pengguna-internal/{user}', [UserController::class, 'destroy'])->name('hapus.pengguna.internal');
    });
    
    // Kelola FAQ (CRUD) - Admin only
    Route::middleware(['permission:kelola-faq'])->group(function () {
        Route::get('/kelola-faq', [FaqController::class, 'index'])->name('daftar.kelola.faq');
        Route::get('/kelola-faq/tambah', [FaqController::class, 'create'])->name('form.tambah.kelola.faq');
        Route::post('/kelola-faq', [FaqController::class, 'store'])->name('tambah.kelola.faq');
        Route::get('/kelola-faq/{faq}/edit', [FaqController::class, 'edit'])->name('form.edit.kelola.faq');
        Route::put('/kelola-faq/{faq}', [FaqController::class, 'update'])->name('edit.kelola.faq');
        Route::delete('/kelola-faq/{faq}', [FaqController::class, 'destroy'])->name('hapus.kelola.faq');
    });

    // Kelola Pengumuman (CRUD) - Admin only
    Route::middleware(['permission:kelola-pengumuman'])->group(function () {
        Route::get('/kelola-pengumuman', [AnnouncementController::class, 'index'])->name('daftar.kelola.pengumuman');
        Route::get('/kelola-pengumuman/tambah', [AnnouncementController::class, 'create'])->name('form.tambah.kelola.pengumuman');
        Route::post('/kelola-pengumuman', [AnnouncementController::class, 'store'])->name('tambah.kelola.pengumuman');
        Route::get('/kelola-pengumuman/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('form.edit.kelola.pengumuman');
        Route::put('/kelola-pengumuman/{announcement}', [AnnouncementController::class, 'update'])->name('edit.kelola.pengumuman');
        Route::delete('/kelola-pengumuman/{announcement}', [AnnouncementController::class, 'destroy'])->name('hapus.kelola.pengumuman');
        
        // File upload route for Trix editor
        Route::post('/kelola-pengumuman/upload-file', [AnnouncementController::class, 'uploadFile'])->name('upload.file.pengumuman');
        

        
        // File access route for uploaded files
        Route::get('/storage/announcements/{filename}', function($filename) {
            $path = storage_path('app/public/announcements/' . $filename);
            if (file_exists($path)) {
                return response()->file($path);
            }
            abort(404);
        })->name('file.announcement')->where('filename', '.*');
        
        // File delete route
        Route::delete('/kelola-pengumuman/delete-file', [AnnouncementController::class, 'deleteFile'])->name('delete.file.pengumuman');
    });
    
    // Akses Pengumuman (View Only) - memerlukan permission akses-pengumuman
    Route::middleware(['permission:akses-pengumuman'])->group(function () {
        Route::get('/akses-pengumuman', [AnnouncementController::class, 'publicIndex'])->name('akses.pengumuman');
        Route::get('/akses-pengumuman/{id}', [AnnouncementController::class, 'publicShow'])->name('akses.pengumuman.detail');
    });
    
    // Kelola Kategori Forum (CRUD) - Admin only
    Route::middleware(['permission:kelola-kategori-forum'])->group(function () {
        Route::get('/kelola-kategori-forum', [ForumCategoryController::class, 'index'])->name('daftar.kelola.kategori.forum');
        Route::get('/kelola-kategori-forum/tambah', [ForumCategoryController::class, 'create'])->name('form.tambah.kelola.kategori.forum');
        Route::post('/kelola-kategori-forum', [ForumCategoryController::class, 'store'])->name('tambah.kelola.kategori.forum');
        Route::get('/kelola-kategori-forum/{forumCategory}/edit', [ForumCategoryController::class, 'edit'])->name('form.edit.kelola.kategori.forum');
        Route::put('/kelola-kategori-forum/{forumCategory}', [ForumCategoryController::class, 'update'])->name('edit.kelola.kategori.forum');
        Route::delete('/kelola-kategori-forum/{forumCategory}', [ForumCategoryController::class, 'destroy'])->name('hapus.kelola.kategori.forum');
    });
    
    // Forum Diskusi (CRUD) - memerlukan permission forum-diskusi
    Route::middleware(['permission:forum-diskusi'])->group(function () {
        Route::get('/forum-diskusi', [ForumDiscussionController::class, 'index'])->name('forum.diskusi');
        Route::get('/forum-diskusi/tambah', [ForumDiscussionController::class, 'create'])->name('form.tambah.forum.diskusi');
        Route::post('/forum-diskusi', [ForumDiscussionController::class, 'store'])->name('tambah.forum.diskusi');
        Route::get('/forum-diskusi/{id}', [ForumDiscussionController::class, 'show'])->name('forum.diskusi.detail');
        Route::post('/forum-diskusi/{id}/komentar', [ForumDiscussionController::class, 'storeComment'])->name('tambah.komentar');
        Route::post('/forum-diskusi/{id}/like', [ForumDiscussionController::class, 'toggleLikeDiscussion'])->name('forum.diskusi.like');
        Route::get('/forum-diskusi/{id}/edit', [ForumDiscussionController::class, 'edit'])->name('form.edit.forum.diskusi');
        Route::put('/forum-diskusi/{id}', [ForumDiscussionController::class, 'update'])->name('edit.forum.diskusi');
        Route::delete('/forum-diskusi/{id}', [ForumDiscussionController::class, 'destroy'])->name('hapus.forum.diskusi');
        Route::post('/forum-komentar/{commentId}/like', [ForumDiscussionController::class, 'toggleLikeComment'])->name('forum.komentar.like');
    });
    
    // Unggah Pengetahuan - memerlukan permission unggah-pengetahuan
    Route::middleware(['permission:unggah-pengetahuan'])->group(function () {
        Route::get('/unggah-pengetahuan', [KnowledgeController::class, 'userIndex'])->name('unggah.pengetahuan');
        Route::get('/unggah-pengetahuan/tambah', [KnowledgeController::class, 'create'])->name('unggah.pengetahuan.create');
        Route::post('/unggah-pengetahuan', [KnowledgeController::class, 'store'])->name('unggah.pengetahuan.store');
        Route::get('/unggah-pengetahuan/{id}', [KnowledgeController::class, 'show'])->name('unggah.pengetahuan.detail');
        Route::get('/unggah-pengetahuan/{knowledge}/download', [KnowledgeController::class, 'download'])->name('unggah.pengetahuan.download');
    });
    
    // Verifikasi Pengetahuan - memerlukan permission verifikasi-pengetahuan
    Route::middleware(['permission:verifikasi-pengetahuan'])->group(function () {
        Route::get('/verifikasi-pengetahuan', [KnowledgeController::class, 'verificationIndex'])->name('verifikasi.pengetahuan');
        Route::get('/verifikasi-pengetahuan/{knowledge}', [KnowledgeController::class, 'verificationShow'])->name('verifikasi.pengetahuan.detail');
        Route::post('/verifikasi-pengetahuan/{knowledge}/approve', [KnowledgeController::class, 'approve'])->name('verifikasi.pengetahuan.approve');
        Route::post('/verifikasi-pengetahuan/{knowledge}/reject', [KnowledgeController::class, 'reject'])->name('verifikasi.pengetahuan.reject');
    });
    
    // Validasi Pengetahuan - memerlukan permission validasi-pengetahuan
    Route::middleware(['permission:validasi-pengetahuan'])->group(function () {
        Route::get('/validasi-pengetahuan', [KnowledgeController::class, 'validationIndex'])->name('validasi.pengetahuan');
        Route::get('/validasi-pengetahuan/{knowledge}', [KnowledgeController::class, 'validationShow'])->name('validasi.pengetahuan.detail');
        Route::post('/validasi-pengetahuan/{knowledge}/validate', [KnowledgeController::class, 'validateKnowledge'])->name('validasi.pengetahuan.validate');
        Route::post('/validasi-pengetahuan/{knowledge}/reject', [KnowledgeController::class, 'rejectValidation'])->name('validasi.pengetahuan.reject');
    });
    
    // Repositori Publik - accessible to all authenticated users
    Route::get('/repositori-publik', [KnowledgeController::class, 'publicIndex'])->name('repositori.publik');
    Route::get('/repositori-publik/{knowledge}', [KnowledgeController::class, 'publicShow'])->name('repositori.publik.detail');
    Route::get('/repositori-publik/{knowledge}/download', [KnowledgeController::class, 'publicDownload'])->name('repositori.publik.download');
    
    // Kelola Repositori - Admin only
    Route::middleware(['permission:kelola-repositori'])->group(function () {
        Route::get('/kelola-repositori', [KnowledgeController::class, 'repositoryIndex'])->name('kelola.repositori');
        Route::get('/kelola-repositori/{knowledge}', [KnowledgeController::class, 'repositoryShow'])->name('kelola.repositori.detail');
        Route::delete('/kelola-repositori/{knowledge}', [KnowledgeController::class, 'repositoryDestroy'])->name('kelola.repositori.destroy');
    });
    
    // Kelola Kategori Pengetahuan (CRUD) - Admin only
    Route::middleware(['permission:kelola-kategori-pengetahuan'])->group(function () {
        Route::resource('kelola-kategori-pengetahuan', KnowledgeCategoryController::class)->names([
            'index' => 'kelola.kategori.pengetahuan.index',
            'create' => 'kelola.kategori.pengetahuan.create',
            'store' => 'kelola.kategori.pengetahuan.store',
            'show' => 'kelola.kategori.pengetahuan.show',
            'edit' => 'kelola.kategori.pengetahuan.edit',
            'update' => 'kelola.kategori.pengetahuan.update',
            'destroy' => 'kelola.kategori.pengetahuan.destroy',
        ]);
    });
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
