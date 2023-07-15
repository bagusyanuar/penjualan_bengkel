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

    Route::group(['prefix' => 'pembelian'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\PembelianController::class, 'index'])->name('pembelian');
        Route::get('/{id}/info', [\App\Http\Controllers\PembelianController::class, 'info'])->name('pembelian.info');
        Route::match(['get', 'post'], '/tambah', [\App\Http\Controllers\PembelianController::class, 'add'])->name('pembelian.add');
        Route::post( '/tambah/{id}/delete', [\App\Http\Controllers\PembelianController::class, 'deleteCart'])->name('pembelian.add.delete.cart');
    });

    Route::group(['prefix' => 'penjualan'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\PenjualanController::class, 'index'])->name('penjualan');
        Route::get('/{id}/info', [\App\Http\Controllers\PenjualanController::class, 'info'])->name('penjualan.info');
        Route::match(['get', 'post'], '/tambah', [\App\Http\Controllers\PenjualanController::class, 'add'])->name('penjualan.add');
        Route::get( '/tambah/{id}/barang', [\App\Http\Controllers\PenjualanController::class, 'detail_barang'])->name('penjualan.add.detail.barang');
        Route::post( '/tambah/{id}/delete', [\App\Http\Controllers\PenjualanController::class, 'deleteCart'])->name('penjualan.add.delete.cart');
    });

    Route::group(['prefix' => 'pembayaran-hutang'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\PembayaranHutangController::class, 'index'])->name('pembayaran-hutang');
        Route::match(['get', 'post'], '/tambah', [\App\Http\Controllers\PembayaranHutangController::class, 'add'])->name('pembayaran-hutang.add');
        Route::post('/{id}/delete', [\App\Http\Controllers\PembayaranHutangController::class, 'destroy'])->name('pembayaran-hutang.delete');
    });

    Route::group(['prefix' => 'pembayaran-piutang'], function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\PembayaranPiutangController::class, 'index'])->name('pembayaran-piutang');
        Route::match(['get', 'post'], '/tambah', [\App\Http\Controllers\PembayaranPiutangController::class, 'add'])->name('pembayaran-piutang.add');
        Route::post('/{id}/delete', [\App\Http\Controllers\PembayaranPiutangController::class, 'destroy'])->name('pembayaran-piutang.delete');
    });
});

