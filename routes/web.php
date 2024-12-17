<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\MhsController;
use App\Http\Controllers\PembayaranController;

// Rute untuk login dan logout
Route::get('/', [InstansiController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [InstansiController::class, 'login'])->name('login');
Route::post('/logout', [InstansiController::class, 'logout'])->name('logout');

// Rute dengan middleware
Route::middleware(['auth'])->group(function () {
    // Rute untuk admin
    Route::prefix('instansi')->name('instansi.')->middleware(['role:admin'])->group(function () {
        Route::get('/home', [InstansiController::class, 'home'])->name('home');
        Route::get('/dataTrx', [InstansiController::class, 'dataTrx'])->name('dataTrx');
        Route::get('/va_byr', [InstansiController::class, 'vaPembayaran'])->name('va_byr');
        Route::get('/man_pem', [InstansiController::class, 'manajemenPembayaran'])->name('man_pem');
        Route::get('/man_pem1', [InstansiController::class, 'mP1'])->name('man_pem1');
        Route::get('/man_pem2', [InstansiController::class, 'mP2'])->name('man_pem2');
        //Route::get('/cetak', [InstansiController::class, 'cetak'])->name('cetak');
        Route::get('/cetak/{id_tagihan}', [InstansiController::class, 'cetak'])->name('cetak');

        Route::get('/databyr', [PembayaranController::class, 'databyr'])->name('instansi.databyr');
        Route::get('/pembayaran/tambah', [PembayaranController::class, 'create'])->name('instansi.tmbh_byr');
        Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('instansi.store'); // Menyimpan data pembayaran
        Route::get('/pembayaran/edit/{id}', [PembayaranController::class, 'edit'])->name('instansi.edit_byr');
        Route::put('/pembayaran/update/{id}', [PembayaranController::class, 'update'])->name('instansi.update');
        Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('instansi.deletePembayaran');
        Route::get('/tagihan', [InstansiController::class, 'getTagihan'])->name('getTagihan');

        // Rute untuk mahasiswa
        Route::get('/mahasiswa', [MhsController::class, 'showMahasiswa'])->name('mhs');
        Route::get('/mahasiswa/tambah', [MhsController::class, 'tambahMahasiswaForm'])->name('tambahMhsForm');
        Route::post('/mahasiswa/store', [MhsController::class, 'store'])->name('storeMhs');
        Route::delete('/mahasiswa/{id}', [MhsController::class, 'delete'])->name('deleteMhs');
        Route::get('/mahasiswa/edit/{id}', [MhsController::class, 'editMahasiswaForm'])->name('editMhsForm');
        Route::put('/mahasiswa/update/{id}', [MhsController::class, 'updateMahasiswa'])->name('updateMhs');
    });

    // Rute untuk mahasiswa
    Route::prefix('maha')->name('maha.')->middleware(['role:mahasiswa'])->group(function () {
        Route::get('/profil', [MhsController::class, 'profil'])->name('profil');
        Route::get('/bayar', [MhsController::class, 'bayar'])->name('bayar');
        Route::get('/saldo', [MhsController::class, 'saldo'])->name('saldo');
        Route::get('/pb', [MhsController::class, 'pb'])->name('pb');
        Route::post('/detail', [MhsController::class, 'detail'])->name('detail');
        Route::get('/trx', [MhsController::class, 'trx'])->name('trx');
        Route::get('/rw', [MhsController::class, 'rw'])->name('rw');
    });

    Route::get('/get-va', [InstansiController::class, 'getVA']);
});
