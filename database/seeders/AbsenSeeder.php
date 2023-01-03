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
                'categories' => "Kelas"
            ],
            [
                'name' => 'SETORAN',
                'categories' => "Pengajar"

            ],
            [
                'name' => 'SHALAT',
                'categories' => "Program"

            ],
            [
                'name' => 'QIYAMULAIL',
                'categories' => "Program"
            ],
        ];
        foreach ($absen as $data) {
            MasterAttendance::create($data);
        }
    }
}
