<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class HrdController extends Controller
{
    public function index()
    {
        App::setLocale('id');
        $user = Auth::user();
        // dd(auth()->user());
        $karyawan = Employee::where('hak_akses', 'karyawan')->where('active', 'Ya')->count();
        $manajer = Employee::where('hak_akses', 'manajer')->where('active', 'Ya')->count();
        $hrd = Employee::where('hak_akses', 'hrd')->where('active', 'Ya')->count();
        return view('hrd.index', compact('user', 'karyawan', 'hrd', 'manajer'));
    }
}
