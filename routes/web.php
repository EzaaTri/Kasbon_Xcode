<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\HistoryController;
use App\Http\Middleware\RoleMiddleware;

// Jika sudah login, langsung ke dashboard
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::post('/register/check-email', [AuthController::class, 'checkEmail'])->name('register.check-email');
    Route::post('/register/check-phone', [AuthController::class, 'checkPhone'])->name('register.check-phone');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/reset-password', [AuthController::class, 'showResetPasswordFormProfile'])->name('profile.reset-password');
    Route::post('/profile/reset-password', [AuthController::class, 'updatePasswordFromProfile'])->name('profile.update-password');
});

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/kelola-akun', [AdminController::class, 'showKelolaAkun'])->name('kelola_akun');
    Route::get('/detail-akun/{id}', [AdminController::class, 'showDetailAkun'])->name('detail_akun');
    Route::get('/pengajuan-akun', [AdminController::class, 'showPengajuanAkun'])->name('pengajuan_akun');
    Route::post('/konfirmasi-akun/{id}', [AdminController::class, 'konfirmasiAkun'])->name('konfirmasi_akun');
    Route::post('/tolak-akun', [AdminController::class, 'tolakAkun'])->name('tolak_akun');
    Route::get('/pinjaman', [AdminController::class, 'showPinjaman'])->name('admin.pinjaman.index');
    Route::get('/pinjaman/{id}/detail', [AdminController::class, 'detail'])->name('admin.pinjaman_detail');
    Route::post('/pinjaman/{id}/approve', [AdminController::class, 'approvePinjaman'])->name('admin.pinjaman_approve');
    Route::post('/pinjaman/reject/{id}', [AdminController::class, 'rejectPinjaman'])->name('admin.pinjaman_reject');
    Route::get('/kelola-pengajuan-pinjaman', [AdminController::class, 'showPengajuanPinjaman'])->name('admin.pengajuan_pinjaman');
    Route::get('/admin/history', [HistoryController::class, 'index'])->name('admin.history.index');
    Route::get('/pelunasan', [AdminController::class, 'daftarPelunasan'])->name('admin.pelunasan');
    Route::post('/pelunasan/setujui/{id}', [AdminController::class, 'setujuiPelunasan'])->name('admin.pelunasan.setujui');
    Route::post('/pelunasan/tolak/{id}', [AdminController::class, 'tolakPelunasan'])->name('admin.pelunasan.tolak');
});

Route::middleware([RoleMiddleware::class . ':karyawan'])->group(function () {
    Route::get('/karyawan/dashboard', [KaryawanController::class, 'index']);
    Route::get('/pengajuan-pinjaman', [KaryawanController::class, 'showPengajuanPinjaman'])->name('pengajuan_pinjaman');
    Route::post('/pinjaman/store', [KaryawanController::class, 'store'])->name('pinjaman.store');
    Route::get('/tagihan', [KaryawanController::class, 'showTagihanKaryawan'])->name('karyawan.tagihan');
    Route::get('/tagihan/{id}/pelunasan', [KaryawanController::class, 'pelunasanTagihan'])->name('karyawan.pelunasan');
    Route::post('/tagihan/{id}/konfirmasi', [KaryawanController::class, 'konfirmasiPelunasan'])->name('karyawan.konfirmasi_pelunasan');
    Route::get('/karyawan/riwayat', [HistoryController::class, 'karyawanIndex'])->name('karyawan.history');
    Route::delete('pinjaman/{id}', [KaryawanController::class, 'destroy'])->name('pinjaman.destroy');
    Route::get('/pinjaman/detail/{id}', [KaryawanController::class, 'detail'])->name('detail_pinjaman');
});
