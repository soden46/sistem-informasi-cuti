<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create(
            [
                'npp' => '1244',
                'id_divisi' => '1',
                'nama_emp' => 'manajer',
                'jk_emp' => 'Laki-Laki',
                'jabatan' => 'manajer',
                'alamat' => 'manajer',
                'hak_akses' => 'manajer',
                'jml_cuti' => '2',
                'password' => 'manajer',
                'foto_emp' => 'manajer',
                'active' => '1',
                'telp_emp' => '9437462352',
                'password' => Hash::make('Manajer'),
                'created_at' => '2024-02-04 10:30:27',
                'updated_at' => '2024-02-04 10:30:27'
            ]
        );
        Employee::create([
            'npp' => '1233',
            'id_divisi' => '2',
            'nama_emp' => 'hrd',
            'jk_emp' => 'Laki-Laki',
            'jabatan' => 'hrd',
            'alamat' => 'hrd',
            'hak_akses' => 'hrd',
            'jml_cuti' => '2',
            'password' => 'hrd',
            'foto_emp' => 'hrd',
            'active' => '1',
            'telp_emp' => '048575752',
            'password' => Hash::make('Hrd'),
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);
        Employee::create(
            [
                'npp' => '1223',
                'id_divisi' => '2',
                'nama_emp' => 'karyawan',
                'jk_emp' => 'Laki-Laki',
                'jabatan' => 'karyawan',
                'alamat' => 'karyawan',
                'hak_akses' => 'karyawan',
                'jml_cuti' => '2',
                'password' => 'karyawan',
                'foto_emp' => 'karyawan',
                'active' => '1',
                'telp_emp' => '048575752',
                'password' => Hash::make('Karyawan'),
                'created_at' => '2024-02-04 10:30:27',
                'updated_at' => '2024-02-04 10:30:27'
            ]
        );
    }
}
