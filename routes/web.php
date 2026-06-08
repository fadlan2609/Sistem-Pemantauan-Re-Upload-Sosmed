<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ReuploadController;
use Illuminate\Support\Facades\Route;

// Halaman utama redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route untuk dashboard (butuh login)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard berdasarkan role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // ==================== ROUTE UNTUK ADMIN ====================
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // ---------- Impersonate (Login as Karyawan) ----------
        Route::get('/impersonate', [ImpersonateController::class, 'index'])->name('impersonate');
        Route::post('/impersonate/{id}', [ImpersonateController::class, 'loginAs'])->name('impersonate.login');
        Route::get('/impersonate/logout', [ImpersonateController::class, 'logoutAs'])->name('impersonate.logout');
        
        // ---------- Kelola Karyawan (CRUD) ----------
        Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan');
        Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
        Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
        Route::get('/karyawan/{id}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
        Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
        Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
        
        // ---------- Kelola Konten Bulanan (CRUD) ----------
        Route::get('/konten', [KontenController::class, 'index'])->name('konten');
        Route::get('/konten/create', [KontenController::class, 'create'])->name('konten.create');
        Route::post('/konten', [KontenController::class, 'store'])->name('konten.store');
        Route::get('/konten/{id}/edit', [KontenController::class, 'edit'])->name('konten.edit');
        Route::put('/konten/{id}', [KontenController::class, 'update'])->name('konten.update');
        Route::delete('/konten/{id}', [KontenController::class, 'destroy'])->name('konten.destroy');
        
        // ---------- Verifikasi Re-upload (VALIDASI) ----------
        // 🔥 PENTING: Urutan route STATIS (batch, quick) harus DI ATAS route DINAMIS ({id}) 🔥
        Route::get('/verifikasi', [ReuploadController::class, 'pendingVerification'])->name('verifikasi');
        
        // ROUTE STATIS (tanpa parameter) - Letakkan di ATAS
        Route::post('/verifikasi/batch', [ReuploadController::class, 'batchVerify'])->name('verifikasi.batch');
        Route::post('/verifikasi/quick/{userId}/{contentId}', [ReuploadController::class, 'quickVerify'])->name('verifikasi.quick');
        
        // ROUTE DINAMIS (dengan parameter) - Letakkan di BAWAH
        Route::post('/verifikasi/{id}', [ReuploadController::class, 'verify'])->name('verifikasi.verify');
        Route::delete('/verifikasi/{id}', [ReuploadController::class, 'reject'])->name('verifikasi.reject');
        
        // ---------- Laporan Bulanan (PDF & Excel) ----------
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [LaporanController::class, 'index'])->name('index');
            Route::post('/generate', [LaporanController::class, 'generate'])->name('generate');
            Route::get('/pdf', [LaporanController::class, 'exportPdf'])->name('pdf');
            Route::get('/excel', [LaporanController::class, 'exportExcel'])->name('excel');
        });
    });
    
    // ==================== ROUTE UNTUK KARYAWAN ====================
    Route::prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/reupload/{contentId}', [ReuploadController::class, 'create'])->name('reupload');
        Route::post('/reupload/{contentId}', [ReuploadController::class, 'store'])->name('reupload.store');
    });
});

// Include auth routes bawaan Laravel
require __DIR__.'/auth.php';