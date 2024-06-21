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
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'keterangan' => 'required',
        ]);

        // Ambil jenis cuti berdasarkan id_jenis_cuti dari request
        $jenisCuti = JenisCutiModel::findOrFail($request->id_jenis_cuti);

        // Hitung tanggal awal dan akhir
        $tgl_awal = Carbon::parse($request->tgl_awal);
        $tgl_akhir = Carbon::parse($request->tgl_akhir);

        // Hitung durasi cuti berdasarkan tgl_awal dan tgl_akhir
        $durasiCutiBaru = $tgl_awal->diffInDays($tgl_akhir) + 1;

        // Ambil total durasi cuti yang sudah diambil oleh karyawan dengan npp dan id_jenis_cuti yang sama
        $totalDurasiDiambil = CutiModel::where('npp', auth()->user()->npp)
            ->where('id_jenis_cuti', $request->id_jenis_cuti)
            ->sum('durasi');

        // Kurangi lama_cuti dengan total durasi cuti yang sudah diambil
        $lamaCuti = $jenisCuti->lama_cuti;

        // Pengecekan jika user belum pernah mengajukan cuti dengan id_jenis_cuti yang sama
        if ($totalDurasiDiambil == 0) {
            $sisaCuti = $lamaCuti - $durasiCutiBaru;
            if ($durasiCutiBaru > $lamaCuti) {
                return redirect()->back()->withErrors(['error' => 'Durasi cuti yang diajukan melebihi lama cuti yang tersedia.']);
            }
        } else {
            $sisaCuti = $lamaCuti - $totalDurasiDiambil;
            if ($durasiCutiBaru > $sisaCuti) {
                return redirect()->back()->withErrors(['error' => 'Durasi cuti yang diajukan melebihi sisa cuti yang tersedia.']);
            }
        }

        // Simpan data cuti baru
        $cuti = new CutiModel();
        $cuti->npp = auth()->user()->npp; // Ganti dengan logika sesuai dengan model dan relasi Anda
        $cuti->id_jenis_cuti = $request->id_jenis_cuti;
        $cuti->tgl_awal = $tgl_awal->toDateString();
        $cuti->tgl_akhir = $tgl_akhir->toDateString();
        $cuti->durasi = $durasiCutiBaru;
        $cuti->kuota_cuti = $sisaCuti - $durasiCutiBaru; // Update sisa cuti setelah cuti diajukan
        $cuti->keterangan = $request->keterangan;
        $cuti->stt_cuti = "Pending";
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
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'keterangan' => 'required',
        ]);

        // Ambil data cuti yang akan diupdate
        $cuti = CutiModel::findOrFail($no_cuti);

        // Ambil jenis cuti berdasarkan id_jenis_cuti dari request
        $jenisCuti = JenisCutiModel::findOrFail($request->id_jenis_cuti);

        // Hitung tanggal awal dan akhir
        $tgl_awal = Carbon::parse($request->tgl_awal);
        $tgl_akhir = Carbon::parse($request->tgl_akhir);

        // Hitung durasi cuti berdasarkan tgl_awal dan tgl_akhir
        $durasiCutiBaru = $tgl_awal->diffInDays($tgl_akhir) + 1;

        // Ambil total durasi cuti yang sudah diambil oleh karyawan dengan npp dan id_jenis_cuti yang sama, kecuali cuti yang sedang diupdate
        $totalDurasiDiambil = CutiModel::where('npp', auth()->user()->npp)
            ->where('id_jenis_cuti', $request->id_jenis_cuti)
            ->where('no_cuti', '!=', $no_cuti)
            ->sum('durasi');

        // Kurangi lama_cuti dengan total durasi cuti yang sudah diambil
        $lamaCuti = $jenisCuti->lama_cuti;
        $sisaCuti = $lamaCuti - $totalDurasiDiambil;

        // Validasi jika durasi cuti yang diajukan melebihi sisa cuti yang tersedia
        if ($durasiCutiBaru > $sisaCuti) {
            return redirect()->back()->withErrors(['error' => 'Durasi cuti yang diajukan melebihi sisa cuti yang tersedia.']);
        }

        // Update data cuti
        $cuti->id_jenis_cuti = $request->id_jenis_cuti;
        $cuti->tgl_awal = $tgl_awal->toDateString();
        $cuti->tgl_akhir = $tgl_akhir->toDateString();
        $cuti->durasi = $durasiCutiBaru;
        $cuti->kuota_cuti = $sisaCuti; // Perlu disesuaikan berdasarkan logika bisnis Anda
        $cuti->keterangan = $request->keterangan;
        $cuti->stt_cuti = "Pending"; // Jika diperlukan, sesuaikan dengan logika bisnis Anda
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
