<?php

namespace Database\Seeders;

use App\Models\DivisiModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menyimpan data pertama
        DivisiModel::create([
            'id_divisi' => '1',
            'nama_divisi' => 'manajer divisi',
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);

        // Menyimpan data kedua
        DivisiModel::create([
            'id_divisi' => '2',
            'nama_divisi' => 'nama divisi lainnya',
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);

        // Menyimpan data ketiga
        DivisiModel::create([
            'id_divisi' => '3',
            'nama_divisi' => 'karyawan',
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);
    }
}
