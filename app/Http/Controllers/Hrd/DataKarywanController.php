<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\DivisiModel;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DataKarywanController extends Controller
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
            return view('hrd.karyawan.index', [
                'title' => 'Data aryawan',
                'karyawan' => Employee::with('divisi')->where('hak_akses', 'karyawan')->orWhere('nama_emp', 'like', "%{$cari}%")->paginate(10),
                'div' => DivisiModel::get(),
            ]);
        } else {
            return view('hrd.karyawan.index', [
                'title' => 'Data Karyawan',
                'karyawan' => Employee::with('divisi')->where('hak_akses', 'karyawan')->paginate(10),
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
        return view('hrd.karyawan.create', [
            'title' => 'Tambah Data Karyawan',
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
            'jabatan' => 'required|max:50',
            'alamat' => 'required',
            'hak_akses' => 'required|max:20',
            'jml_cuti' => 'nullable|max:11',
            'password' => 'required',
            'foto_emp' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'required',
            'telp_emp' => 'nullable|max:20',
        ];

        // dd($request->all());
        $validatedData = $request->validate($rules);

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Proses upload foto
        if ($request->hasFile('foto_emp')) {
            $fotoPath = $request->file('foto_emp')->store('karyawan');
            $validatedData['foto_emp'] = $fotoPath;
        } else {
            $validatedData['foto_emp'] = null; // Set default jika tidak ada foto diupload
        }

        // Buat data karyawan
        Employee::create($validatedData);

        return redirect()->route('hrd.karyawan')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $divisi, $npp)
    {

        return view('hrd.karyawan.edit', [
            'title' => 'Edit Data karyawan',
            'karyawan' => Employee::with('divisi')->where('npp', $npp)->first(),
            'div' => DivisiModel::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $npp)
    {
        // Define validation rules
        $rules = [
            'id_divisi' => 'required',
            'nama_emp' => 'required|max:20',
            'jk_emp' => 'required',
            'jabatan' => 'required|max:50',
            'alamat' => 'required',
            'hak_akses' => 'required|max:20',
            'jml_cuti' => 'nullable|max:11',
            'password' => 'nullable',
            'foto_emp' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'required',
            'telp_emp' => 'nullable|max:20',
        ];

        // Validate request data
        $validatedData = $request->validate($rules);

        // Hash password if it is provided
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']); // Remove password from validated data if it's empty
        }

        // Handle file upload if a new file is provided
        if ($request->hasFile('foto_emp')) {
            $fotoPath = $request->file('foto_emp')->store('karyawan');
            $validatedData['foto_emp'] = $fotoPath;
        }

        // Update the employee data
        Employee::where('npp', $npp)->update($validatedData);

        return redirect()->route('hrd.karyawan')->with('success', 'Data has been updated');
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
        return redirect()->route('hrd.karyawan')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Karayawan',
            'karyawan' => Employee::with('divisi')->get(),
        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('hrd.laporan.karyawan', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('laporan-data-karyawan.pdf');
    }
}
