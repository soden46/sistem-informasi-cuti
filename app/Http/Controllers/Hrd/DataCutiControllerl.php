<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\CutiModel;
use App\Models\Employee;
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

        $query = CutiModel::with('jenisCuti');

        // Ambil nilai dari input pencarian
        $cari = $request->cari;

        // Filter berdasarkan pencarian teks jika ada nilai pencarian
        if ($cari != NULL) {
            $query->where(function ($query) use ($cari) {
                $query->where('no_cuti', 'like', "%{$cari}%")
                    ->orWhere('stt_cuti', 'like', "%{$cari}%")
                    ->orWhere('npp', 'like', "%{$cari}%");
            });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->where(function ($query) use ($request) {
                $query->whereDate('tgl_awal', '>=', $request->start_date)
                    ->whereDate('tgl_akhir', '<=', $request->end_date);
            });
        } elseif ($request->filled('start_date')) {
            $query->where(function ($query) use ($request) {
                $query->whereDate('tgl_awal', '>=', $request->start_date);
            });
        } elseif ($request->filled('end_date')) {
            $query->where(function ($query) use ($request) {
                $query->whereDate('tgl_akhir', '<=', $request->end_date);
            });
        }

        // Ambil data dengan pagination
        $cuti = $query->paginate(10);

        return view('hrd.cuti.index', [
            'title' => 'Data Cuti',
            'cuti' => $cuti,
        ]);
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
            'employee' => Employee::get(),
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
            'id_jenis_cuti' => 'required',
            'npp' => 'required|max:10',
            'id_jenis_cuti' => 'required|integer',
            'tgl_pengajuan' => 'required|date',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date',
            'durasi' => 'required|integer',
            'keterangan' => 'required|string|max:255',
            'stt_cuti' => 'required|string|max:10',
            'ket_reject' => 'required|string',
        ];

        $validatedData = $request->validate($rules);

        CutiModel::create($validatedData);

        return redirect()->route('hrd.cuti')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit($no_cuti)
    {

        return view('hrd.cuti.edit', [
            'title' => 'Edit Data Cuti',
            'cuti' => CutiModel::with('jenisCuti')->where('no_cuti', $no_cuti)->first(),
            'jenisCuti' => JenisCutiModel::get(),
            'employee' => Employee::get(),
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
            'id_jenis_cuti' => 'required',
            'npp' => 'required|max:10',
            'id_jenis_cuti' => 'required|integer',
            'tgl_pengajuan' => 'required|date',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date',
            'durasi' => 'required|integer',
            'keterangan' => 'required|string|max:255',
            'stt_cuti' => 'required|string|max:10',
            'ket_reject' => 'required|string',
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

    public function pdf(Request $request)
    {
        // dd($request);
        // Ambil nilai start_date dan end_date dari request
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Query untuk mengambil data cuti
        $query = CutiModel::with('jenisCuti');

        // Filter berdasarkan tanggal jika start_date dan end_date terisi
        if ($start_date && $end_date) {
            $query->whereBetween('tgl_awal', [$start_date, $end_date])
                ->orWhereBetween('tgl_akhir', [$start_date, $end_date]);
        } elseif ($start_date) {
            $query->where('tgl_awal', '>=', $start_date)
                ->orWhere('tgl_akhir', '>=', $start_date);
        } elseif ($end_date) {
            $query->where('tgl_awal', '<=', $end_date)
                ->orWhere('tgl_akhir', '<=', $end_date);
        }

        // Ambil data cuti sesuai filter
        $cuti = $query->get();

        // Data untuk dikirim ke view PDF
        $data = [
            'title' => 'Laporan Data Cuti',
            'cuti' => $cuti,
            'start_date' => $start_date, // Tambahkan start_date untuk ditampilkan di PDF
            'end_date' => $end_date,     // Tambahkan end_date untuk ditampilkan di PDF
        ];

        // Load view PDF dengan menggunakan library DomPDF
        $pdf = PDF::loadView('hrd.pdf.cuti', $data)->setPaper('A4', 'landscape');

        // Menggunakan stream untuk menampilkan PDF di browser
        return $pdf->stream("laporan-data-cuti.pdf");
    }
}
