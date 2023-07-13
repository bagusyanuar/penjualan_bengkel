<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::match(['post', 'get'],'/', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth'], function (){
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'pengguna'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\PenggunaController::class, 'index'])->name('pengguna');
        Route::post('/{id}', [\App\Http\Controllers\PenggunaController::class, 'patch'])->name('pengguna.update');
        Route::post('/{id}/delete', [\App\Http\Controllers\PenggunaController::class, 'destroy'])->name('pengguna.delete');
    });

    Route::group(['prefix' => 'supplier'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\SupplierController::class, 'index'])->name('supplier');
        Route::post('/{id}', [\App\Http\Controllers\SupplierController::class, 'patch'])->name('supplier.update');
        Route::post('/{id}/delete', [\App\Http\Controllers\SupplierController::class, 'destroy'])->name('supplier.delete');
    });

    Route::group(['prefix' => 'kategori'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\KategoriController::class, 'index'])->name('kategori');
        Route::post('/{id}', [\App\Http\Controllers\KategoriController::class, 'patch'])->name('kategori.update');
        Route::post('/{id}/delete', [\App\Http\Controllers\KategoriController::class, 'destroy'])->name('kategori.delete');
    });

    Route::group(['prefix' => 'barang'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\BarangController::class, 'index'])->name('barang');
        Route::post('/{id}', [\App\Http\Controllers\BarangController::class, 'patch'])->name('barang.update');
        Route::post('/{id}/delete', [\App\Http\Controllers\BarangController::class, 'destroy'])->name('barang.delete');
    });
});

