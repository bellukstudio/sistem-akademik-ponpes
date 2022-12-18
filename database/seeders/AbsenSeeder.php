<?php

namespace Database\Seeders;

use App\Models\MasterAttendance;
use Illuminate\Database\Seeder;

class AbsenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $absen = [
            [
                'name' => 'TAKLIM',
                'column' => "No,Nama,Kelas,Program"
            ],
            [
                'name' => 'ABC',
                'column' => "No,Nama,Kelas,Program"
            ],
        ];
        foreach ($absen as $data) {
            MasterAttendance::create($data);
        }
    }
}
