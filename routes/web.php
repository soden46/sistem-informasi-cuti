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
use App\Http\Controllers\Hrd\DataDivisiController;
use App\Http\Controllers\Hrd\DataJenisCutiController;
use App\Http\Controllers\Hrd\DataKarywanController;
use App\Http\Controllers\Hrd\HrdController;
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
Route::post('/authenticate', [LoginController::class, 'authenticate']);
Route::post('/register', [RegisterController::class, 'store'])->name('register');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

//admin
Route::group(['prefix' => 'manajer hrd', 'as' => 'manajer.'], function () {
    Route::get('/dashbord', [AdminController::class, 'dashboard'])->name('index');
    // Admin
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin', 'index')->name('manajer');
        Route::get('/manajer/create', 'create')->name('manajer.create');
        Route::post('/manajer/save', 'store')->name('manajer.save');
        Route::get('/manajer/edit/{id_manajer}', 'edit')->name('manajer.edit');
        Route::post('/manajer/update/{id_manajer}', 'update')->name('manajer.update');
        Route::delete('/manajer/{id_manajer}', 'destroy')->name('manajer.destroy');
        Route::get('/manajer/cetak', 'pdf')->name('manajer.cetak');
    });
    // Pembina
    Route::controller(DataPembinaController::class)->group(function () {
        Route::get('/pembina', 'index')->name('pembina');
        Route::get('/pembina/create', 'create')->name('pembina.create');
        Route::post('/pembina/save', 'store')->name('pembina.save');
        Route::get('/pembina/edit/{id_pembina}', 'edit')->name('pembina.edit');
        Route::post('/pembina/update/{id_pembina}', 'update')->name('pembina.update');
        Route::delete('/pembina/{id_pembina}', 'destroy')->name('pembina.destroy');
        Route::get('/pembina/cetak', 'pdf')->name('pembina.cetak');
    });
    // Siswa
    Route::controller(DataSiswaController::class)->group(function () {
        Route::get('/siswa', 'index')->name('siswa');
        Route::get('/siswa/create', 'create')->name('siswa.create');
        Route::post('/siswa/save', 'store')->name('siswa.save');
        Route::get('/siswa/edit/{id_siswa}', 'edit')->name('siswa.edit');
        Route::post('/siswa/update/{id_siswa}', 'update')->name('siswa.update');
        Route::delete('/siswa/{id_siswa}', 'destroy')->name('siswa.destroy');
        Route::get('/siswa/cetak', 'pdf')->name('siswa.cetak');
    });
    // Ekstarkulikuler
    Route::controller(DataEkskulController::class)->group(function () {
        Route::get('/ekskul', 'index')->name('ekskul');
        Route::get('/ekskul/create', 'create')->name('ekskul.create');
        Route::post('/ekskul/save', 'store')->name('ekskul.save');
        Route::get('/ekskul/edit/{id_ekskul}', 'edit')->name('ekskul.edit');
        Route::post('/ekskul/update/{id_ekskul}', 'update')->name('ekskul.update');
        Route::delete('/ekskul/{id_ekskul}', 'destroy')->name('ekskul.destroy');
        Route::get('/ekskul/cetak', 'pdf')->name('ekskul.cetak');
    });
    // Rekrutmen
    Route::controller(DataEkskulController::class)->group(function () {
        Route::get('/rekrutmen', 'index')->name('rekrutmen');
        Route::get('/rekrutmen/create', 'create')->name('rekrutmen.create');
        Route::post('/rekrutmen/save', 'store')->name('rekrutmen.save');
        Route::get('/rekrutmen/edit/{id_rekrutmen}', 'edit')->name('rekrutmen.edit');
        Route::post('/rekrutmen/update/{id_rekrutmen}', 'update')->name('rekrutmen.update');
        Route::delete('/rekrutmen/{id_rekrutmen}', 'destroy')->name('rekrutmen.destroy');
        Route::get('/rekrutmen/cetak', 'pdf')->name('rekrutmen.cetak');
    });
    // Pendaftaran
    Route::controller(DataEkskulController::class)->group(function () {
        Route::get('/pendaftaran', 'index')->name('pendaftaran');
        Route::get('/pendaftaran/create', 'create')->name('pendaftaran.create');
        Route::post('/pendaftaran/save', 'store')->name('pendaftaran.save');
        Route::get('/pendaftaran/edit/{id_pendaftaran}', 'edit')->name('pendaftaran.edit');
        Route::post('/pendaftaran/update/{id_pendaftaran}', 'update')->name('pendaftaran.update');
        Route::delete('/pendaftaran/{id_pendaftaran}', 'destroy')->name('pendaftaran.destroy');
        Route::get('/pendaftaran/cetak', 'pdf')->name('pendaftaran.cetak');
    });
    // Jadwal Tes
    Route::controller(DataEkskulController::class)->group(function () {
        Route::get('/jadwal', 'index')->name('jadwal');
        Route::get('/jadwal/create', 'create')->name('jadwal.create');
        Route::post('/jadwal/save', 'store')->name('jadwal.save');
        Route::get('/jadwal/edit/{id_jadwal}', 'edit')->name('jadwal.edit');
        Route::post('/jadwal/update/{id_jadwal}', 'update')->name('jadwal.update');
        Route::delete('/jadwal/{id_jadwal}', 'destroy')->name('jadwal.destroy');
        Route::get('/jadwal/cetak', 'pdf')->name('jadwal.cetak');
    });
    // Hasil Akhir
    Route::controller(DataEkskulController::class)->group(function () {
        Route::get('/hasil', 'index')->name('hasil');
        Route::get('/hasil/create', 'create')->name('hasil.create');
        Route::post('/hasil/save', 'store')->name('hasil.save');
        Route::get('/hasil/edit/{id_hasil}', 'edit')->name('hasil.edit');
        Route::post('/hasil/update/{id_hasil}', 'update')->name('hasil.update');
        Route::delete('/hasil/{id_hasil}', 'destroy')->name('hasil.destroy');
        Route::get('/hasil/cetak', 'pdf')->name('hasil.cetak');
    });
    // Pengumuman
    Route::controller(DataEkskulController::class)->group(function () {
        Route::get('/pengumuman', 'index')->name('pengumuman');
        Route::get('/pengumuman/create', 'create')->name('pengumuman.create');
        Route::post('/pengumuman/save', 'store')->name('pengumuman.save');
        Route::get('/pengumuman/edit/{id_pengumuman}', 'edit')->name('pengumuman.edit');
        Route::post('/pengumuman/update/{id_pengumuman}', 'update')->name('pengumuman.update');
        Route::delete('/pengumuman/{id_pengumuman}', 'destroy')->name('pengumuman.destroy');
        Route::get('/pengumuman/cetak', 'pdf')->name('pengumuman.cetak');
    });
});

//pembina
Route::group(['prefix' => 'hrd', 'as' => 'hrd.'], function () {
    Route::get('/dashboard', [HrdController::class, 'index'])->name('index');

    // Data Karyawan
    Route::get('/karyawan', [DataKarywanController::class, 'index'])->name('karyawan');
    Route::get('/karyawan/create', [DataKarywanController::class, 'create'])->name('karyawan.create');
    Route::post('/karyawan/save', [DataKarywanController::class, 'store'])->name('karyawan.save');
    Route::get('/karyawan/edit/{npp}', [DataKarywanController::class, 'edit'])->name('karyawan.edit');
    Route::post('/karyawan/update/{npp}', [DataKarywanController::class, 'update'])->name('karyawan.update');
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
    Route::get('/jenis-cuti/edit/{id_jenis}', [DataJenisCutiController::class, 'edit'])->name('jeniscuti.edit');
    Route::post('/jenis-cuti/update/{id_jenis}', [DataJenisCutiController::class, 'update'])->name('jeniscuti.update');
    Route::delete('/jenis-cuti/{id_jenis}', [DataJenisCutiController::class, 'destroy'])->name('jeniscuti.destroy');
    Route::get('/jenis-cuti/cetak', [DataJenisCutiController::class, 'pdf'])->name('jeniscuti.cetak');
});


//siswa
Route::group(['prefix' => 'siswa', 'as' => 'siswa.'], function () {
    Route::get('/dashbord', [AdminController::class, 'index'])->name('siswa');

    // Route Resource
});
