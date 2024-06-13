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
use App\Http\Controllers\Hrd\HrdController;
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
    // Admin
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

    // Data Divisi
    Route::get('/divisi', [ManajerDataDivisiController::class, 'index'])->name('divisi');
    Route::get('/divisi/create', [ManajerDataDivisiController::class, 'create'])->name('divisi.create');
    Route::post('/divisi/save', [ManajerDataDivisiController::class, 'store'])->name('divisi.save');
    Route::get('/divisi/edit/{id_divisi}', [ManajerDataDivisiController::class, 'edit'])->name('divisi.edit');
    Route::post('/divisi/update/{id_divisi}', [ManajerDataDivisiController::class, 'update'])->name('divisi.update');
    Route::delete('/divisi/{id_divisi}', [ManajerDataDivisiController::class, 'destroy'])->name('divisi.destroy');
    Route::get('/divisi/cetak', [ManajerDataDivisiController::class, 'pdf'])->name('divisi.cetak');

    // Data Jenis Cuti
    Route::get('/jenis-cuti', [ManajerDataJenisCutiController::class, 'index'])->name('jeniscuti');
    Route::get('/jenis-cuti/create', [ManajerDataJenisCutiController::class, 'create'])->name('jeniscuti.create');
    Route::post('/jenis-cuti/save', [ManajerDataJenisCutiController::class, 'store'])->name('jeniscuti.save');
    Route::get('/jenis-cuti/edit/{id_jenis_cuti}', [ManajerDataJenisCutiController::class, 'edit'])->name('jeniscuti.edit');
    Route::post('/jenis-cuti/update/{id_jenis_cuti}', [ManajerDataJenisCutiController::class, 'update'])->name('jeniscuti.update');
    Route::delete('/jenis-cuti/{id_jenis_cuti}', [ManajerDataJenisCutiController::class, 'destroy'])->name('jeniscuti.destroy');
    Route::get('/jenis-cuti/cetak', [ManajerDataJenisCutiController::class, 'pdf'])->name('jeniscuti.cetak');

    // Data Cuti
    Route::get('/cuti', [ManajerDataCutiControllerl::class, 'index'])->name('cuti');
    Route::get('/cuti/create', [ManajerDataCutiControllerl::class, 'create'])->name('cuti.create');
    Route::post('/cuti/save', [ManajerDataCutiControllerl::class, 'store'])->name('cuti.save');
    Route::get('/cuti/edit/{id_jenis}', [ManajerDataCutiControllerl::class, 'edit'])->name('cuti.edit');
    Route::post('/cuti/update/{id_jenis}', [ManajerDataCutiControllerl::class, 'update'])->name('cuti.update');
    Route::delete('/cuti/{id_jenis}', [ManajerDataCutiControllerl::class, 'destroy'])->name('cuti.destroy');
    Route::get('/cuti/cetak', [ManajerDataCutiControllerl::class, 'pdf'])->name('cuti.cetak');
});

//Karyawan
Route::group(['prefix' => 'siswa', 'as' => 'siswa.'], function () {
    Route::get('/dashbord', [AdminController::class, 'index'])->name('siswa');

    // Route Resource
});
