<?php

namespace Database\Seeders;

use App\Models\CutiModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CutiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        CutiModel::create([
            'no_cuti' => '1',
            'npp' => '1244',
            'id_jenis_cuti' => '1',
            'tgl_pengajuan' => '2024-02-04',
            'tgl_awal' => '2024-02-05',
            'tgl_akhir' => '2024-02-08',
            'durasi' => '3',
            'keterangan' => 'cuti',
            'stt_cuti' => 'Pending',
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);

        CutiModel::create([
            'no_cuti' => '2',
            'npp' => '1233',
            'id_jenis_cuti' => '2',
            'tgl_pengajuan' => '2024-02-04',
            'tgl_awal' => '2024-02-05',
            'tgl_akhir' => '2024-02-08',
            'durasi' => '3',
            'keterangan' => 'cuti',
            'stt_cuti' => 'Pending',
            'ket_reject' => '',
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);

        CutiModel::create([
            'no_cuti' => '3',
            'npp' => '1223',
            'id_jenis_cuti' => '3',
            'tgl_pengajuan' => '2024-02-04',
            'tgl_awal' => '2024-02-05',
            'tgl_akhir' => '2024-02-08',
            'durasi' => '3',
            'keterangan' => 'cuti',
            'stt_cuti' => 'Pending',
            'ket_reject' => '',
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);
    }
}
