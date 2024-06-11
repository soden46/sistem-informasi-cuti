<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\DivisiModel;
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

        if ($cari != NULL) {
            return view('hrd.divisi.index', [
                'title' => 'Data Divisi',
                'divisi' => DivisiModel::where('nama_divisi', 'like', "%{$cari}%")->paginate(10),
            ]);
        } else {
            return view('hrd.divisi.index', [
                'title' => 'Data Divisi',
                'divisi' => DivisiModel::paginate(10),
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
        return view('hrd.divisi.create', [
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
            'id_divisi' => 'required|max:5',
            'nama_divisi' => 'required|max:20',
        ]);

        // dd($validatedData);
        DivisiModel::create($validatedData);

        return redirect()->route('hrd.divisi.index')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(DivisiModel $divisi, $id_divisi)
    {
        return view('hrd.divisi.edit', [
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
        $rules = [
            'id_divisi' => 'required|max:5',
            'nama_divisi' => 'required|max:20',
        ];


        $validatedData = $request->validate($rules);

        DivisiModel::where('id_divisi', $id_divisi)->update($validatedData);

        return redirect()->route('hrd.divisi')->with('success', 'Data has ben updated');
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
        return redirect()->route('hrd.siswa')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Divisi',
            'divisi' => DivisiModel::get(),
        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('hrd.laporan.divisi', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('surat-keterangan-biasa.pdf');
    }
}
