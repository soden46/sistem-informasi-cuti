<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use App\Models\Lamaran;
use App\Models\Pelamar;
use App\Models\News;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Caffe;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManajerController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        // dd(auth()->user());
        $karyawan = Employee::where('hak_akses', 'karyawan')->where('active', 'Ya')->count();
        $hrd = Employee::where('hak_akses', 'hrd')->where('active', 'Ya')->count();
        return view('manajer.index', compact('user', 'karyawan', 'hrd'));
    }
}