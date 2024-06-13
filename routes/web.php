<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmailUndanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DataEkskulController;
use App\Http\Controllers\admin\DataPembinaController;
use App\Http\Controllers\admin\DataSiswaController;
use App\Http\Controllers\Hrd\DataCutiControllerl;
use App\Http\Controllers\Hrd\DataDivisiController;
use App\Http\Controllers\Hrd\DataJenisCutiController;
use App\Http\Controllers\Hrd\DataKarywanController;
use App\Http\Controllers\Hrd\DataManajerController;
use App\Http\Controllers\Hrd\HrdController;
use App\Http\Controllers\Karyawan\CutiController;
use App\Http\Controllers\Karyawan\KaryawanController;
use App\Http\Controllers\Manajer\DataCutiControllerl as ManajerDataCutiControllerl;
use App\Http\Controllers\Manajer\DataDivisiController as ManajerDataDivisiController;
use App\Http\Controllers\Manajer\DataJenisCutiController as ManajerDataJenisCutiController;
use App\Http\Controllers\Manajer\DataKarywanController as ManajerDataKarywanController;
use App\Http\Controllers\Manajer\ManajerController;
use App\Http\Controllers\Siswa\SiswaController;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/', [LoginController::class, 'index'])->middleware('guest');
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/authenticate', [LoginController::class, 'authenticate']);
Route::post('/register', [RegisterController::class, 'store'])->name('register');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

//HRD
Route::group(['prefix' => 'hrd', 'as' => 'hrd.'], function () {
    Route::get('/dashboard', [HrdController::class, 'index'])->name('index');

    // Data Karyawan
    Route::get('/karyawan', [DataKarywanController::class, 'index'])->name('karyawan');
    Route::get('/karyawan/create', [DataKarywanController::class, 'create'])->name('karyawan.create');
    Route::post('/karyawan/save', [DataKarywanController::class, 'store'])->name('karyawan.save');
    Route::get('/karyawan/edit/{npp}', [DataKarywanController::class, 'edit'])->name('karyawan.edit');
    Route::put('/karyawan/update/{npp}', [DataKarywanController::class, 'update'])->name('karyawan.update');
    Route::delete('/karyawan/{npp}', [DataKarywanController::class, 'destroy'])->name('karyawan.destroy');
    Route::get('/karyawan/cetak', [DataKarywanController::class, 'pdf'])->name('karyawan.cetak');

    // Data Manajer
    Route::get('/manajer', [DataManajerController::class, 'index'])->name('manajer');
    Route::get('/manajer/create', [DataManajerController::class, 'create'])->name('manajer.create');
    Route::post('/manajer/save', [DataManajerController::class, 'store'])->name('manajer.save');
    Route::get('/manajer/edit/{npp}', [DataManajerController::class, 'edit'])->name('manajer.edit');
    Route::put('/manajer/update/{npp}', [DataManajerController::class, 'update'])->name('manajer.update');
    Route::delete('/manajer/{npp}', [DataManajerController::class, 'destroy'])->name('manajer.destroy');
    Route::get('/manajer/cetak', [DataManajerController::class, 'pdf'])->name('manajer.cetak');

    // Data Divisi
    Route::get('/divisi', [DataDivisiController::class, 'index'])->name('divisi');
    Route::get('/divisi/create', [DataDivisiController::class, 'create'])->name('divisi.create');
    Route::post('/divisi/save', [DataDivisiController::class, 'store'])->name('divisi.save');
    Route::get('/divisi/edit/{id_divisi}', [DataDivisiController::class, 'edit'])->name('divisi.edit');
    Route::post('/divisi/update/{id_divisi}', [DataDivisiController::class, 'update'])->name('divisi.update');
    Route::delete('/divisi/{id_divisi}', [DataDivisiController::class, 'destroy'])->name('divisi.destroy');
    Route::get('/divisi/cetak', [DataDivisiController::class, 'pdf'])->name('divisi.cetak');

    // Data Jenis Cuti
    Route::get('/jenis-cuti', [DataJenisCutiController::class, 'index'])->name('jeniscuti');
    Route::get('/jenis-cuti/create', [DataJenisCutiController::class, 'create'])->name('jeniscuti.create');
    Route::post('/jenis-cuti/save', [DataJenisCutiController::class, 'store'])->name('jeniscuti.save');
    Route::get('/jenis-cuti/edit/{id_jenis_cuti}', [DataJenisCutiController::class, 'edit'])->name('jeniscuti.edit');
    Route::put('/jenis-cuti/update/{id_jenis_cuti}', [DataJenisCutiController::class, 'update'])->name('jeniscuti.update');
    Route::delete('/jenis-cuti/{id_jenis_cuti}', [DataJenisCutiController::class, 'destroy'])->name('jeniscuti.destroy');
    Route::get('/jenis-cuti/cetak', [DataJenisCutiController::class, 'pdf'])->name('jeniscuti.cetak');

    // Data Cuti
    Route::get('/cuti', [DataCutiControllerl::class, 'index'])->name('cuti');
    Route::get('/cuti/create', [DataCutiControllerl::class, 'create'])->name('cuti.create');
    Route::post('/cuti/save', [DataCutiControllerl::class, 'store'])->name('cuti.save');
    Route::get('/cuti/edit/{no_cuti}', [DataCutiControllerl::class, 'edit'])->name('cuti.edit');
    Route::put('/cuti/update/{no_cuti}', [DataCutiControllerl::class, 'update'])->name('cuti.update');
    Route::delete('/cuti/{no_cuti}', [DataCutiControllerl::class, 'destroy'])->name('cuti.destroy');
    Route::get('/cuti/cetak', [DataCutiControllerl::class, 'pdf'])->name('cuti.cetak');
});

//Manajer Divisi
Route::group(['prefix' => 'manajer', 'as' => 'manajer.'], function () {
    Route::get('/dashbord', [ManajerController::class, 'index'])->name('index');
    // Manajer Divisi
    Route::controller(ManajerController::class)->group(function () {
        Route::get('/manajer', 'index')->name('manajer');
    });
    // Data Karyawan
    Route::get('/karyawan', [ManajerDataKarywanController::class, 'index'])->name('karyawan');
    Route::get('/karyawan/create', [ManajerDataKarywanController::class, 'create'])->name('karyawan.create');
    Route::post('/karyawan/save', [ManajerDataKarywanController::class, 'store'])->name('karyawan.save');
    Route::get('/karyawan/edit/{npp}', [ManajerDataKarywanController::class, 'edit'])->name('karyawan.edit');
    Route::post('/karyawan/update/{npp}', [ManajerDataKarywanController::class, 'update'])->name('karyawan.update');
    Route::delete('/karyawan/{npp}', [ManajerDataKarywanController::class, 'destroy'])->name('karyawan.destroy');
    Route::get('/karyawan/cetak', [ManajerDataKarywanController::class, 'pdf'])->name('karyawan.cetak');

    // Data Cuti
    Route::get('/cuti', [ManajerDataCutiControllerl::class, 'index'])->name('cuti');
    Route::get('/cuti/create', [ManajerDataCutiControllerl::class, 'create'])->name('cuti.create');
    Route::post('/cuti/save', [ManajerDataCutiControllerl::class, 'store'])->name('cuti.save');
    Route::get('/cuti/edit/{no_cuti}', [ManajerDataCutiControllerl::class, 'edit'])->name('cuti.edit');
    Route::put('/cuti/update/{no_cuti}', [ManajerDataCutiControllerl::class, 'update'])->name('cuti.update');
    Route::delete('/cuti/{no_cuti}', [ManajerDataCutiControllerl::class, 'destroy'])->name('cuti.destroy');
    Route::get('/cuti/cetak', [ManajerDataCutiControllerl::class, 'pdf'])->name('cuti.cetak');
});

//Karyawan
Route::group(['prefix' => 'karyawan', 'as' => 'karyawan.'], function () {
    Route::get('/dashboard', [KaryawanController::class, 'index'])->name('index');

    Route::controller(KaryawanController::class)->group(function () {
        Route::get('/karyawan', 'index')->name('karyawan');
    });

    Route::get('/cuti', [CutiController::class, 'index'])->name('cuti');
    Route::get('/cuti/create', [CutiController::class, 'create'])->name('cuti.create');
    Route::post('/cuti/save', [CutiController::class, 'store'])->name('cuti.save');
    Route::get('/cuti/edit/{no_cuti}', [CutiController::class, 'edit'])->name('cuti.edit');
    Route::PUT('/cuti/update/{no_cuti}', [CutiController::class, 'update'])->name('cuti.update');
    Route::delete('/cuti/{no_cuti}', [CutiController::class, 'destroy'])->name('cuti.destroy');
    Route::get('/cuti/cetak', [CutiController::class, 'pdf'])->name('cuti.cetak');
    // Route Resource
});
