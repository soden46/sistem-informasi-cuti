<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\JenisCutiModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DataJenisCutiController extends Controller
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
            return view('hrd.jenis-cuti.index', [
                'title' => 'Data Jenis Cuti',
                'jenis' => JenisCutiModel::where(function ($query) use ($cari) {
                    $query->where('nama_cuti', 'like', "%{$cari}%");
                })->paginate(10),
            ]);
        } else {
            return view('hrd.jenis-cuti.index', [
                'title' => 'Data Jenis Cuti',
                'jenis' => JenisCutiModel::paginate(10),
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
        return view('hrd.jenis-cuti.create', [
            'title' => 'Tambah Jenis Cuti',
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
            'nama_cuti' => 'required|max:20',
            'lama_cuti' => 'required|max:3',
        ];

        $validatedData = $request->validate($rules);

        JenisCutiModel::create($validatedData);

        return redirect()->route('hrd.jeniscuti')->with('success', 'Data has been created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit($id_jenis_cuti)
    {

        return view('hrd.jenis-cuti.edit', [
            'title' => 'Edit Data Jenis Cuti',
            'jenis' => JenisCutiModel::where('id_jenis_cuti', $id_jenis_cuti)->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_jenis_cuti)
    {
        $rules = [
            'nama_cuti' => 'required|max:20',
            'lama_cuti' => 'required|max:3',
        ];

        $validatedData = $request->validate($rules);

        JenisCutiModel::where('id_jenis_cuti', $id_jenis_cuti)->update($validatedData);

        return redirect()->route('hrd.jeniscuti')->with('success', 'Data has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_jenis_cuti)
    {
        JenisCutiModel::where('id_jenis_cuti', $id_jenis_cuti)->delete();
        return redirect()->route('hrd.jeniscuti')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Jenis Cuti',
            'jenis' => JenisCutiModel::get(),
        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('hrd.jenis-cuti.pdf', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('laporan-data-jenis-cuti.pdf');
    }
}
