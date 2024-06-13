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
            'npp ' => 'required|max:5',
            'id_divisi ' => 'required',
            'nama_emp ' => 'required|max:20',
            'jk_emp ' => 'required',
            'jabatan ' => 'required|max:50',
            'alamat ' => 'required',
            'hak_akses ' => 'required|max:20',
            'jml_cuti ' => 'required|max:11',
            'password ' => 'required',
            'foto_emp ' => 'required|png,jpg,jpeg|max:2048',
            'active ' => 'required',
            'telp_emp ' => 'required|20',
        ];

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

        Employee::create($validatedData);

        // dd($validatedData);
        Employee::create($validatedData);

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
            'npp ' => 'required|max:5',
            'id_divisi ' => 'required',
            'nama_emp ' => 'required|max:20',
            'jk_emp ' => 'required',
            'jabatan ' => 'required|max:50',
            'alamat ' => 'required',
            'hak_akses ' => 'required|max:20',
            'jml_cuti ' => 'required|max:11',
            'password ' => 'required',
            'foto_emp ' => 'required|png,jpg,jpeg|max:2048',
            'active ' => 'required',
            'telp_emp ' => 'required|20',
        ];

        $validatedData = $request->validate($rules);

        $validatedData['password'] = Hash::make($validatedData['password']);

        // Proses update data karyawan
        $employee = Employee::where('npp', $npp)->first();

        // Jika ada file foto yang diupload
        if ($request->hasFile('foto_emp')) {
            // Hapus foto lama jika ada
            if ($employee->foto_emp) {
                Storage::delete($employee->foto_emp);
            }

            // Simpan foto baru
            $fotoPath = $request->file('foto_emp')->store('karyawan');
            $validatedData['foto_emp'] = $fotoPath;
        }

        $employee->update($validatedData);

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
