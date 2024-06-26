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
            'nama_divisi' => 'hrd',
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);

        // Menyimpan data kedua
        DivisiModel::create([
            'nama_divisi' => 'manajer',
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);

        // Menyimpan data ketiga
        DivisiModel::create([
            'nama_divisi' => 'karyawan',
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);
    }
}
