<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\CutiModel;
use App\Models\Employee;
use App\Models\JenisCutiModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'npp' => 'required|string|max:255',
            'id_jenis_cuti' => 'required|integer',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date',
            'durasi' => 'required|integer',
            'bukti_cuti' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'keterangan' => 'required|string|max:255',
        ]);

        $cuti = new CutiModel();
        $cuti->npp = $request->npp;
        $cuti->id_jenis_cuti = $request->id_jenis_cuti;
        $cuti->tgl_awal = $request->tgl_awal;
        $cuti->tgl_akhir = $request->tgl_akhir;
        $cuti->durasi = $request->durasi;

        if ($request->hasFile('bukti_cuti')) {
            $bukti_cuti = $request->file('bukti_cuti')->store('karyawan/cuti');
            $cuti->bukti_cuti = $bukti_cuti;
        }

        $cuti->keterangan = $request->keterangan;
        $cuti->save();

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
        $request->validate([
            'npp' => 'required|string|max:255',
            'id_jenis_cuti' => 'required|integer',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date',
            'durasi' => 'required|integer',
            'bukti_cuti' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'keterangan' => 'required|string|max:255',
        ]);

        $cuti = CutiModel::findOrFail($no_cuti);
        $cuti->npp = $request->npp;
        $cuti->id_jenis_cuti = $request->id_jenis_cuti;
        $cuti->tgl_awal = $request->tgl_awal;
        $cuti->tgl_akhir = $request->tgl_akhir;
        $cuti->durasi = $request->durasi;

        // Menghapus file lampiran yang lama jika ada file baru diupload
        if ($request->hasFile('bukti_cuti')) {
            // Hapus file lampiran lama dari penyimpanan
            if ($cuti->bukti_cuti) {
                Storage::delete($cuti->bukti_cuti);
            }

            // Simpan file baru ke penyimpanan
            $bukti_cuti = $request->file('bukti_cuti')->store('karyawan/cuti');
            $cuti->bukti_cuti = $bukti_cuti;
        }

        $cuti->keterangan = $request->keterangan;
        $cuti->save();

        $cuti->keterangan = $request->keterangan;
        $cuti->save();

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
