<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\DivisiModel;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DataDivisiController extends Controller
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
            return view('manajer.divisi.index', [
                'title' => 'Data Divisi',
                'divisi' => DivisiModel::where('id_divisi', $manajer->id_divisi)->orWhere('nama_divisi', 'like', "%{$cari}%")->paginate(10),
            ]);
        } else {
            return view('manajer.divisi.index', [
                'title' => 'Data Divisi',
                'divisi' => DivisiModel::where('id_divisi', $manajer->id_divisi)->paginate(10),
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
        return view('manajer.divisi.create', [
            'title' => 'Tambah Data Divisi',
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

        $validatedData = $request->validate([
            'nama_divisi' => 'required|max:20',
        ]);

        // dd($validatedData);
        DivisiModel::create($validatedData);

        return redirect()->route('manajer.divisi.index')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(DivisiModel $divisi, $id_divisi)
    {
        return view('manajer.divisi.edit', [
            'title' => 'Edit Data Divisi',
            'divisi' => DivisiModel::where('id_divisi', $id_divisi)->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_divisi)
    {
        // dd($request->all());
        $rules = [
            'nama_divisi' => 'required|max:20',
        ];

        $validatedData = $request->validate($rules);

        DivisiModel::where('id_divisi', $id_divisi)->update($validatedData);

        return redirect()->route('manajer.divisi')->with('success', 'Data has ben updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_divisi)
    {
        DivisiModel::where('id_divisi', $id_divisi)->delete();
        return redirect()->route('manajer.siswa')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Divisi',
            'divisi' => DivisiModel::get(),
        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('manajer.laporan.divisi', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('surat-keterangan-biasa.pdf');
    }
}
