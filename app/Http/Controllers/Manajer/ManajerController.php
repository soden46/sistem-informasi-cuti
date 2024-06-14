<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use App\Models\Lamaran;
use App\Models\Pelamar;
use App\Models\News;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Caffe;
use App\Models\CutiModel;
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
        $manajer = Employee::where('npp', auth()->user()->npp)->first();
        // dd(auth()->user());
        $karyawan = Employee::where('hak_akses', 'karyawan')->where('hak_akses', 'karyawan')->where('id_divisi', $manajer->id_divisi)->where('active', 'Ya')->count();
        $pending = CutiModel::with('jenisCuti', 'employee')
            ->join('employee', 'cuti.npp', '=', 'employee.npp')
            ->where('employee.id_divisi', auth()->user()->id_divisi)
            ->where('stt_cuti', '=',  'Pending')
            ->count();
        $approve = CutiModel::with('jenisCuti', 'employee')
            ->join('employee', 'cuti.npp', '=', 'employee.npp')
            ->where('employee.id_divisi', auth()->user()->id_divisi)
            ->where('stt_cuti', '=', 'Approved')
            ->count();
        $reject = CutiModel::with('jenisCuti', 'employee')
            ->join('employee', 'cuti.npp', '=', 'employee.npp')
            ->where('employee.id_divisi', auth()->user()->id_divisi)
            ->where('stt_cuti', '=', 'Reject')
            ->count();
        return view('manajer.index', compact('user', 'karyawan', 'pending', 'approve', 'reject'));
    }
}
