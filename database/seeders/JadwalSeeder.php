<?php

namespace Database\Seeders;

use App\Models\TrxSchedule;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jadwal = [
            // [
            //     'teacher_id' => 1,
            //     'course_id' => 1,
            //     'class_id' => 1,
            //     'day' => 'Senin',
            //     'time' => 'Shubuh'
            // ],
        ];
        foreach ($jadwal as $data) {
            TrxSchedule::create($data);
        }
    }
}
