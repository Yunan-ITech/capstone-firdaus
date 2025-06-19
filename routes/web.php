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

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
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
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/assets', [ReportController::class, 'assets'])->name('reports.assets');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});
