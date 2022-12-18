<?php

namespace Database\Seeders;

use App\Models\TrxPicketSchedule;
use Illuminate\Database\Seeder;

class JadwalPiketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jadwal = [
            [
                'student_id' => 1,
                'time' => 'Jumat',
                'room_id' => 1,

            ],
            [
                'student_id' => 2,
                'time' => 'Jumat',
                'room_id' => 2,
            ],

        ];
        foreach ($jadwal as $data) {
            TrxPicketSchedule::create($data);
        }
    }
}
