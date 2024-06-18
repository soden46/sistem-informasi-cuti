<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\Pelamar;
use App\Models\Caffe;
use App\Models\LowonganPekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    public function index()
    {
        App::setLocale('id');
        dd(auth()->user());
        if (!auth()->check()) {
            abort(403);
        }
        if (auth()->user()->hak_akses == 'manajer') {
            dd(auth()->user());
            return view('manajer.index');
        }
        if (auth()->user()->hak_akses == 'hrd') {
            return view('hrd.index');
        }
        if (auth()->user()->hak_akses == 'karyawan') {
            return view('karyawan.index');
        }
    }
}
