<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\CutiModel;
use App\Models\Employee;
use App\Models\JenisCutiModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari;

        if ($cari != NULL) {
            return view('karyawan.cuti.index', [
                'title' => 'Data Cuti',
                'cuti' => CutiModel::with('jenisCuti')->where('npp', auth()->user()->npp)->where('no_cuti', 'like', "%{$cari}%")->paginate(10),
                'karyawan' => Employee::where('npp', auth()->user()->npp)->first()
            ]);
        } else {
            return view('karyawan.cuti.index', [
                'title' => 'Data Cuti',
                'cuti' => CutiModel::with('jenisCuti')->where('npp', auth()->user()->npp)->paginate(10),
                'karyawan' => Employee::where('npp', auth()->user()->npp)->first()
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
        return view('karyawan.cuti.create', [
            'title' => 'Tambah Jenis Cuti',
            'jenisCuti' => JenisCutiModel::get(),
            'karyawan' => Employee::where('npp', auth()->user()->npp)->first()
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
        // dd($request->all());
        $rules = [
            'npp' => 'required|max:10',
            'id_jenis_cuti' => 'required',
            'tgl_pengajuan' => 'required|date',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date',
            'durasi' => 'required|integer',
            'keterangan' => 'required|string|max:255',
        ];

        $validatedData = $request->validate($rules);

        CutiModel::create([
            'npp' => $validatedData['npp'],
            'id_jenis_cuti' => $validatedData['id_jenis_cuti'],
            'tgl_pengajuan' => $validatedData['tgl_pengajuan'],
            'tgl_awal' => $validatedData['tgl_awal'],
            'tgl_akhir' => $validatedData['tgl_akhir'],
            'durasi' => $validatedData['durasi'],
            'keterangan' => $validatedData['keterangan'],
            'stt_cuti' => 'Pending',

        ]);

        return redirect()->route('karyawan.cuti')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit($no_cuti)
    {

        return view('karyawan.cuti.edit', [
            'title' => 'Edit Data Cuti',
            'cuti' => CutiModel::with('jenisCuti')->where('no_cuti', $no_cuti)->first(),
            'jenisCuti' => JenisCutiModel::get(),
            'karyawan' => Employee::where('npp', auth()->user()->npp)->first()
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
        // dd($request->all());
        $rules = [
            'npp' => 'required|max:10',
            'id_jenis_cuti' => 'required',
            'tgl_pengajuan' => 'required|date',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date',
            'durasi' => 'nullable|integer',
            'keterangan' => 'nullable|string|max:255',
        ];

        $validatedData = $request->validate($rules);

        $cuti = CutiModel::where('no_cuti', $no_cuti)->first();

        $cuti->update($validatedData);

        return redirect()->route('karyawan.cuti')->with('success', 'Data has ben updated');
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
        return redirect()->route('karyawan.cuti')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Cuti',
            'jenis' => CutiModel::with('jenisCuti')->get(),
        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('karyawan.laporan.jenis-cuti', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('laporan-data-jenis-cuti.pdf');
    }
}
