<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\CutiModel;
use App\Models\JenisCutiModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DataCutiControllerl extends Controller
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
            return view('hrd.cuti.index', [
                'title' => 'Data Cuti',
                'cuti' => CutiModel::with('jenisCuti')->where('no_cuti', 'like', "%{$cari}%")->paginate(10),
            ]);
        } else {
            return view('hrd.cuti.index', [
                'title' => 'Data Cuti',
                'cuti' => CutiModel::with('jenisCuti')->paginate(10),
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
        return view('hrd.cuti.create', [
            'title' => 'Tambah Jenis Cuti',
            'jenisCuti' => JenisCutiModel::get(),
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
            'no_cuti' => 'required|unique:cutis|max:5',
            'npp' => 'required|max:10',
            'jenis_cuti_id' => 'required|integer',
            'tgl_pengajuan' => 'required|date',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date',
            'durasi' => 'required|integer',
            'keterangan' => 'required|string|max:255',
            'stt_cuti' => 'required|string|max:10',
        ];

        $validatedData = $request->validate($rules);

        CutiModel::create($validatedData);

        return redirect()->route('hrd.jeniscuti')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(JenisCutiModel  $no_cuti)
    {

        return view('hrd.cuti.edit', [
            'title' => 'Edit Data Cuti',
            'cuti' => CutiModel::with('jenisCuti')->where('no_cuti', $no_cuti)->first(),
            'jenisCuti' => JenisCutiModel::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $no_cuti)
    {
        $rules = [
            'npp' => 'required|max:10',
            'jenis_cuti_id' => 'required|integer',
            'tgl_pengajuan' => 'required|date',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date',
            'durasi' => 'required|integer',
            'keterangan' => 'required|string|max:255',
            'stt_cuti' => 'required|string|max:10',
        ];

        $validatedData = $request->validate($rules);

        $cuti = CutiModel::where('no_cuti', $no_cuti)->first();

        $cuti->update($validatedData);

        return redirect()->route('hrd.cuti')->with('success', 'Data has ben updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($no_cuti)
    {
        CutiModel::with('jenisCuti')->where('no_cuti', $no_cuti)->delete();
        return redirect()->route('hrd.cuti')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Cuti',
            'jenis' => CutiModel::with('jenisCuti')->get(),
        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('hrd.laporan.jenis-cuti', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('laporan-data-jenis-cuti.pdf');
    }
}
