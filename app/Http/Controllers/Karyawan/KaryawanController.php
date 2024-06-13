<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\CutiModel;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // dd(auth()->user());
        $cuti = Employee::with('jenisCuti')->where('npp', auth()->user()->npp)->count();
        return view('karyawan.index', compact('cuti'));
    }
}