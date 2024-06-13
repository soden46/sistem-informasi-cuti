<?php

namespace Database\Seeders;

use App\Models\JenisCutiModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisCutiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisCutiModel::create([
            'nama_cuti' => 'melahirkan',
            'lama_cuti' => '2',
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);
        JenisCutiModel::create([
            'nama_cuti' => 'acara keluarga',
            'lama_cuti' => '2',
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);
        JenisCutiModel::create([
            'nama_cuti' => 'liburan',
            'lama_cuti' => '2',
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);
    }
}
