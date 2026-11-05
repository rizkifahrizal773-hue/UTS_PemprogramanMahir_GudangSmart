<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\MutasiStokController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Inventaris GudangSmart
|--------------------------------------------------------------------------
*/

// Redirect root ke dashboard admin
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Rute Autentikasi Publik
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Fallback rute konvensional /dashboard langsung
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| Route Group dengan Prefix 'admin' & Middleware 'auth' (Soal 1 & Soal 5)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // 1. Rute Konvensional untuk DashboardController (/admin/dashboard)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Operasi Khusus Soft Delete Barang (Trash, Restore, Force Delete)
    Route::get('/barang-trash', [BarangController::class, 'trash'])->name('barang.trash');

    // Fitur sensitif: Restore & Force Delete dibatasi hanya untuk Manager Gudang (Soal 5)
    Route::middleware('role:manager')->group(function () {
        Route::post('/barang/{id}/restore', [BarangController::class, 'restore'])->name('barang.restore');
        Route::delete('/barang/{id}/force-delete', [BarangController::class, 'forceDelete'])->name('barang.forceDelete');
    });

    // 3. Resource Route untuk Pengelolaan Data Barang (/admin/barang)
    // Staff Gudang hanya dapat melihat katalog dan tambah barang, tidak dapat menghapus (Soal 5)
    Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])
        ->name('barang.destroy')
        ->middleware('role:manager');

    Route::resource('barang', BarangController::class)->except(['destroy']);

    // 4. Resource Route untuk Pengelolaan Data Supplier (/admin/suppliers)
    // Staff Gudang tidak dapat mengedit atau menghapus supplier (Soal 5)
    Route::middleware('role:manager')->group(function () {
        Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
        Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
        Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
        Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
    });

    Route::resource('suppliers', SupplierController::class)->only(['index', 'show']);

    // 5. Rute Pengelolaan Kategori Barang
    Route::get('/kategori', [KategoriBarangController::class, 'index'])->name('kategori.index');
    Route::post('/kategori', [KategoriBarangController::class, 'store'])->name('kategori.store')->middleware('role:manager');
    Route::delete('/kategori/{kategori}', [KategoriBarangController::class, 'destroy'])->name('kategori.destroy')->middleware('role:manager');

    // 6. Rute Transaksi Mutasi Stok (Barang Masuk & Keluar) - Dapat diakses oleh Staff & Manager
    Route::get('/mutasi', [MutasiStokController::class, 'index'])->name('mutasi.index');
    Route::get('/mutasi/create', [MutasiStokController::class, 'create'])->name('mutasi.create');
    Route::post('/mutasi', [MutasiStokController::class, 'store'])->name('mutasi.store');
});
