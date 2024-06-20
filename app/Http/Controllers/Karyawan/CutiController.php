<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\CutiModel;
use App\Models\Employee;
use App\Models\JenisCutiModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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
        // Validasi data dari form
        $request->validate([
            'id_jenis_cuti' => 'required',
            'tgl_awal' => 'required|date',
            'keterangan' => 'required',
        ]);

        // Ambil jenis cuti berdasarkan id_jenis_cuti dari request
        $jenisCuti = JenisCutiModel::findOrFail($request->id_jenis_cuti);

        // Hitung tanggal akhir (tgl_akhir) berdasarkan tgl_awal dan lama_cuti dari jenis cuti yang dipilih
        $tgl_awal = $request->tgl_awal;
        $lamaCuti = $jenisCuti->lama_cuti;

        $tgl_akhir = Carbon::parse($tgl_awal)->addDays($lamaCuti)->toDateString();

        // Simpan data cuti baru
        $cuti = new CutiModel();
        $cuti->npp = auth()->user()->npp; // Ganti dengan logika sesuai dengan model dan relasi Anda
        $cuti->id_jenis_cuti = $request->id_jenis_cuti;
        $cuti->tgl_awal = $tgl_awal;
        $cuti->tgl_akhir = $tgl_akhir;
        $cuti->durasi = $lamaCuti; // Simpan durasi sesuai lama_cuti dari jenis cuti
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
        // Validasi data dari form
        $request->validate([
            'id_jenis_cuti' => 'required',
            'tgl_awal' => 'required|date',
            'keterangan' => 'required',
        ]);

        // Ambil data cuti berdasarkan $no_cuti
        $cuti = CutiModel::findOrFail($no_cuti);

        // Hitung ulang tanggal akhir (tgl_akhir) jika ada perubahan tgl_awal atau durasi
        $tgl_awal = $request->tgl_awal;
        $lamaCuti = $request->lama_cuti; // Disesuaikan dengan logika aplikasi Anda

        // Hitung tanggal akhir baru berdasarkan tgl_awal dan lama_cuti dari jenis cuti yang dipilih
        $tgl_akhir = Carbon::parse($tgl_awal)->addDays($lamaCuti)->toDateString();

        // Update data cuti
        $cuti->id_jenis_cuti = $request->id_jenis_cuti;
        $cuti->tgl_awal = $tgl_awal;
        $cuti->tgl_akhir = $tgl_akhir;
        $cuti->durasi = $lamaCuti; // Simpan durasi sesuai lama_cuti dari jenis cuti
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
