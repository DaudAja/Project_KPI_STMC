<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Awal');
});

// Route untuk halaman tunggu (tidak kena middleware is_active)
Route::get('/waiting-verification', function () {
    return view('auth.waiting-verification');
})->name('waiting.verification');

// Route yang hanya bisa diakses jika sudah 'active'
Route::middleware(['auth', 'is_active'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard']);
    Route::get('/surat/masuk', [SuratController::class, 'indexMasuk']);
    // ... route lainnya
});

//LOGIN & REGISTER
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//ADMIN
// Di dalam grup Admin
Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
    // Route::post('/admin/users/{id}/approve', [UserController::class, 'approveUser'])->name('admin.verifikasi.setujui');
    // Route::get('/users', [UserController::class, 'verifikasi'])->name('users.index');
    Route::get('/users', [UserController::class, 'verifikasi'])->name('users.index');

    // TAMBAHKAN ROUTE INI:
    Route::patch('/users/{user}/verify', [UserController::class, 'approve'])->name('users.approve');
    Route::delete('/users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');
});

;
// Route::post('/admin/users/{id}/approve', [UserController::class, 'approveUser'])->name('admin.verifikasi.setujui')->middleware('auth');


Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

//SURAT
// Menampilkan Form
Route::get('/surat/input', [SuratController::class, 'input'])->name('surat.input');
// Memproses Form
Route::post('/surat/store', [SuratController::class, 'store'])->name('surat.store');
Route::get('/surat/show', [SuratController::class, 'show'])->name('surat.show');
Route::get('/surat/masuk', [SuratController::class, 'masuk'])->name('surat.masuk');
Route::get('/surat/keluar', [SuratController::class, 'keluar'])->name('surat.keluar');
    // // Proses Simpan ke Database (Yang tadi ada error auth()->id)
    // Route::post('/surat/store', [SuratController::class, 'store'])->name('surat.store');

    // // Halaman Arsip
    // Route::get('/surat/masuk', [SuratController::class, 'indexMasuk'])->name('surat.masuk');
    // Route::get('/surat/keluar', [SuratController::class, 'indexKeluar'])->name('surat.keluar');

    // // Halaman Detail (Untuk melihat PDF)
    // Route::get('/surat/{surat}', [SuratController::class, 'show'])->name('surat.show');
