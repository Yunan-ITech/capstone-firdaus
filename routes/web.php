<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TahunController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\KondisiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\ProfileController;

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

// Authentication Routes
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot/Reset Password
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])
    ->middleware('guest')
    ->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])
    ->middleware('guest')
    ->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // Master Data Routes (with master prefix)
    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('ruangan', RuanganController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('tahun', TahunController::class);
        Route::resource('jenis-barang', JenisBarangController::class);
        Route::resource('kondisi', KondisiController::class);
    });
    
    // Legacy Master Data Routes (without prefix for backward compatibility)
    Route::resource('ruangan', RuanganController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('tahun', TahunController::class);
    Route::resource('jenis-barang', JenisBarangController::class);
    Route::resource('kondisi', KondisiController::class);
    
    // Assets Management
    Route::resource('assets', AssetController::class);
    Route::get('/assets/get-jenis-barang/{kategoriId}', [AssetController::class, 'getJenisBarang'])->name('assets.get-jenis-barang');
    Route::get('/assets/detail/{kode_inventaris_dasar}', [AssetController::class, 'detail'])->name('assets.detail');
    Route::post('/assets/detail/{kode_inventaris_dasar}/add-unit', [AssetController::class, 'addUnit'])->name('assets.addUnit');
    Route::put('/assets/unit/{id}', [AssetController::class, 'updateUnit'])->name('assets.updateUnit');
    Route::delete('/assets/unit/{id}', [AssetController::class, 'deleteUnit'])->name('assets.deleteUnit');
    Route::get('/assets/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit');
    Route::put('/assets/{asset}', [AssetController::class, 'update'])->name('assets.update');
    Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy');

    // Rute untuk mengedit grup barang
    Route::get('/assets/edit-group/{kode_inventaris_dasar}', [AssetController::class, 'editGroup'])->name('assets.editGroup');
    Route::put('/assets/update-group/{kode_inventaris_dasar}', [AssetController::class, 'updateGroup'])->name('assets.updateGroup');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/assets', [ReportController::class, 'assets'])->name('reports.assets');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');

    // Labels
    Route::get('/labels', [LabelController::class, 'index'])->name('labels.index');
    Route::post('/labels/print', [LabelController::class, 'print'])->name('labels.print');
});
