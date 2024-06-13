<?php

namespace App\Http\Controllers\Manajer;

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

        $manajer = Employee::where('npp', auth()->user()->npp)->first();
        if ($cari != NULL) {
            return view('manajer.karyawan.index', [
                'title' => 'Data aryawan',
                'karyawan' => Employee::with('divisi')->where('hak_akses', 'karyawan')->where('id_divisi', $manajer->id_divisi)->orWhere('nama_emp', 'like', "%{$cari}%")->paginate(10),
                'div' => DivisiModel::get(),
            ]);
        } else {
            return view('manajer.karyawan.index', [
                'title' => 'Data Karyawan',
                'karyawan' => Employee::with('divisi')->where('hak_akses', 'karyawan')->where('id_divisi', $manajer->id_divisi)->paginate(10),
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
        return view('manajer.karyawan.create', [
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
            'id_divisi' => 'required',
            'nama_emp' => 'required',
            'jk_emp' => 'required',
            'alamat' => 'required',
            'jml_cuti' => 'nullable|max:11',
            'password' => 'nullable',
            'telp_emp' => 'nullable|max:20',
        ];

        $validatedData = $request->validate($rules);

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

        Employee::create([
            'npp' => $validatedData['npp'],
            'id_divisi' => $validatedData['id_divisi'],
            'nama_emp' => $validatedData['nama_emp'],
            'jk_emp' => $validatedData['jk_emp'],
            'jabatan' => 'karyawan',
            'alamat' => $validatedData['alamat'],
            'hak_akses' => 'karyawan',
            'jml_cuti' => $validatedData['jml_cuti'],
            'password' => $validatedData['password'],
            'active' => $validatedData['active'],
            'telp_emp' => $validatedData['telp_emp']
        ]);

        return redirect()->route('manajer.karyawan.index')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $divisi, $npp)
    {

        return view('manajer.karyawan.edit', [
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
        $rules = [
            'id_divisi' => 'required',
            'nama_emp' => 'required',
            'jk_emp' => 'required',
            'alamat' => 'required',
            'jml_cuti' => 'nullable|max:11',
            'password' => 'nullable',
            'telp_emp' => 'nullable|max:20',
        ];

        $validatedData = $request->validate($rules);

        $validatedData['password'] = Hash::make($validatedData['password']);

        // Proses update data karyawan
        $employee = Employee::where('npp', $npp)->first();

        $employee->update([
            'npp' => $validatedData['npp'],
            'id_divisi' => $validatedData['id_divisi'],
            'nama_emp' => $validatedData['nama_emp'],
            'jk_emp' => $validatedData['jk_emp'],
            'jabatan' => 'karyawan',
            'alamat' => $validatedData['alamat'],
            'hak_akses' => 'karyawan',
            'jml_cuti' => $validatedData['jml_cuti'],
            'password' => $validatedData['password'] ?? $employee->password,
            'active' => $validatedData['active'],
            'telp_emp' => $validatedData['telp_emp']
        ]);

        return redirect()->route('manajer.karyawan')->with('success', 'Data has ben updated');
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
        return redirect()->route('manajer.karyawan')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Karayawan',
            'karyawan' => Employee::with('divisi')->get(),
        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('manajer.karyawan.pdf', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('laporan-data-karyawan.pdf');
    }
}
