<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\DivisiModel;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataManajerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cari = $request->cari;

        if ($cari != NULL) {
            return view('hrd.manajer.index', [
                'title' => 'Data Manajer',
                'manajer' => Employee::with('divisi')->where('hak_akses', 'manajer')->where(function ($query) use ($cari) {
                    $query->where('nama_emp', 'like', "%{$cari}%")
                        ->orWhere('npp', 'like', "%{$cari}%");
                })->paginate(10),
                'div' => DivisiModel::get(),
            ]);
        } else {
            return view('hrd.manajer.index', [
                'title' => 'Data Manajer',
                'manajer' => Employee::with('divisi')->where('hak_akses', 'manajer')->paginate(10),
                'div' => DivisiModel::get(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hrd.manajer.create', [
            'title' => 'Tambah Data Manajer',
            'div' => DivisiModel::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'npp' => 'required|max:5',
            'id_divisi' => 'required',
            'nama_emp' => 'required|max:20',
            'jk_emp' => 'required',
            'alamat' => 'required',
            'password' => 'required',
            'active' => 'required',
            'telp_emp' => 'nullable|max:20',
        ];

        // dd($request->all());
        $validatedData = $request->validate($rules);

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);
        $hak_akses = "manajer";
        $jabatan = "manajer";

        // Buat data karyawan
        Employee::create([
            'npp' => $validatedData['npp'],
            'id_divisi' => $validatedData['id_divisi'],
            'nama_emp' => $validatedData['nama_emp'],
            'jk_emp' => $validatedData['jk_emp'],
            'jabatan' => 'manajer',
            'alamat' => $validatedData['alamat'],
            'hak_akses' => 'manajer',
            'password' => $validatedData['password'],
            'active' => $validatedData['active'],
            'telp_emp' => $validatedData['telp_emp']
        ]);

        return redirect()->route('hrd.manajer')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit($npp)
    {
        // dd($npp);
        return view('hrd.manajer.edit', [
            'title' => 'Edit Data Manajer',
            'manajer' => Employee::with('divisi')->where('npp', $npp)->first(),
            'div' => DivisiModel::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Manajer  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $npp)
    {
        // dd($request->all());
        // Define validation rules
        $rules = [
            'id_divisi' => 'required',
            'nama_emp' => 'required',
            'jk_emp' => 'required',
            'alamat' => 'required',
            'password' => 'nullable',
            'active' => 'nullable',
            'telp_emp' => 'nullable|max:20',
        ];

        // Validate request data
        $validatedData = $request->validate($rules);
        // dd($validatedData);
        // Hash password if it is provided
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']); // Remove password from validated data if it's empty
        }

        $employee = Employee::where('npp', $npp)->first();
        // Update the employee data
        Employee::where('npp', $npp)->update([
            'id_divisi' => $validatedData['id_divisi'],
            'nama_emp' => $validatedData['nama_emp'],
            'jk_emp' => $validatedData['jk_emp'],
            'jabatan' => "manajer",
            'alamat' => $validatedData['alamat'],
            'hak_akses' => "manajer",
            'password' => $validatedData['password'] ?? $employee->password,
            'active' => $validatedData['active'],
            'telp_emp' => $validatedData['telp_emp']
        ]);


        return redirect()->route('hrd.manajer')->with('success', 'Data has been updated');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($npp)
    {
        Employee::where('npp', $npp)->delete();
        return redirect()->route('hrd.manajer')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Manajer',
            'manajer' => Employee::with('divisi')->get(),
        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('hrd.manajer.pdf', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('laporan-data-manajer.pdf');
    }
}
