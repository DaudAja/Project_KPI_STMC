<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- Rute Publik ---
Route::get('/', function () {
    return view('Awal');
});

// --- Rute Autentikasi ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- Rute Terproteksi (Harus Login & Active) ---
Route::get('/waiting-verification', function () {
    $user = Auth::user();
    if ($user && $user->status === 'active') {
        return redirect()->route('dashboard');
    }
    return view('auth.waiting-verification');
})->middleware('auth')->name('waiting.verification');

// Halaman Akun Nonaktif
Route::get('/account-inactive', function () {
    if (Auth::user()->status !== 'inactive') {
        return redirect('/dashboard');
    }
    return view('auth.inactive');
})->middleware('auth')->name('account.inactive');

// --- Rute Terproteksi (Harus Login & Active) ---
Route::middleware(['auth', 'is_active'])->group(function () {

    // Utama
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    // Modul Surat (Grup dengan Prefix 'surat')
    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('/input', [SuratController::class, 'input'])->name('input');
        Route::post('/store', [SuratController::class, 'store'])->name('store');
        Route::get('/masuk', [SuratController::class, 'masuk'])->name('masuk');
        Route::get('/keluar', [SuratController::class, 'keluar'])->name('keluar');
        Route::get('/{surat}', [SuratController::class, 'show'])->name('show');
    });

    // Grup Admin (Verifikasi User)
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        // Manajemen User (Aktif/Nonaktif)
        Route::get('/management', [UserController::class, 'userList'])->name('users.list');
        Route::patch('/users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');

        // Aksi Aktivasi Ulang Akun (PATCH)
        Route::patch('/users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
        // Route::patch('/users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');

        // Halaman Daftar Verifikasi (GET)
        Route::get('/users', [UserController::class, 'verifikasi'])->name('users.index');

        // Aksi Verifikasi (PATCH/DELETE) - INI YANG MEMPERBAIKI ERROR ANDA
        Route::patch('/users/{user}/verify', [UserController::class, 'approve'])->name('users.approve');
        Route::delete('/users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');



        // Route Log Aktivitas (Opsional jika sudah ada controllernya)
        Route::get('/logs', function() { return view('admin.logs'); })->name('logs');
    });
});
