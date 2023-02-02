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
        $ahad = [
            [
                'teacher_id' => 1,
                'course_id' => 1,
                'class_id' => 1,
                'day' => 'Ahad',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 1,
                'class_id' => 2,
                'day' => 'Ahad',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 1,
                'class_id' => 3,
                'day' => 'Ahad',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 1,
                'class_id' => 4,
                'day' => 'Ahad',
                'time' => 'Pagi'
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 2,
                'class_id' => 1,
                'day' => 'Ahad',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 3,
                'course_id' => 3,
                'class_id' => 2,
                'day' => 'Ahad',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 3,
                'class_id' => 3,
                'day' => 'Ahad',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 4,
                'course_id' => 3,
                'class_id' => 4,
                'day' => 'Ahad',
                'time' => 'Malam'
            ],
        ];
        foreach ($ahad as $data) {
            TrxSchedule::create($data);
        }

        $senin = [
            [
                'teacher_id' => 1,
                'course_id' => 4,
                'class_id' => 1,
                'day' => 'Senin',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 4,
                'class_id' => 2,
                'day' => 'Senin',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 4,
                'class_id' => 3,
                'day' => 'Senin',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 4,
                'class_id' => 4,
                'day' => 'Senin',
                'time' => 'Pagi'
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 5,
                'class_id' => 1,
                'day' => 'Senin',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 3,
                'course_id' => 2,
                'class_id' => 2,
                'day' => 'Senin',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 6,
                'class_id' => 3,
                'day' => 'Senin',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 4,
                'course_id' => 7,
                'class_id' => 4,
                'day' => 'Senin',
                'time' => 'Malam'
            ],
        ];
        foreach ($senin as $data) {
            TrxSchedule::create($data);
        }

        $selasa = [
            [
                'teacher_id' => 1,
                'course_id' => 4,
                'class_id' => 1,
                'day' => 'Selasa',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 4,
                'class_id' => 2,
                'day' => 'Selasa',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 4,
                'class_id' => 3,
                'day' => 'Selasa',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 4,
                'class_id' => 4,
                'day' => 'Selasa',
                'time' => 'Pagi'
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 8,
                'class_id' => 1,
                'day' => 'Selasa',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 3,
                'course_id' => 9,
                'class_id' => 2,
                'day' => 'Selasa',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 10,
                'class_id' => 3,
                'day' => 'Selasa',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 4,
                'course_id' => 6,
                'class_id' => 4,
                'day' => 'Selasa',
                'time' => 'Malam'
            ],
        ];
        foreach ($selasa as $data) {
            TrxSchedule::create($data);
        }

        $rabu = [
            [
                'teacher_id' => 1,
                'course_id' => 25,
                'class_id' => 1,
                'day' => 'Rabu',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 25,
                'class_id' => 2,
                'day' => 'Rabu',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 25,
                'class_id' => 3,
                'day' => 'Rabu',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 25,
                'class_id' => 4,
                'day' => 'Rabu',
                'time' => 'Pagi'
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 11,
                'class_id' => 1,
                'day' => 'Rabu',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 3,
                'course_id' => 10,
                'class_id' => 2,
                'day' => 'Rabu',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 6,
                'class_id' => 3,
                'day' => 'Rabu',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 4,
                'course_id' => 12,
                'class_id' => 4,
                'day' => 'Rabu',
                'time' => 'Malam'
            ],
        ];
        foreach ($rabu as $data) {
            TrxSchedule::create($data);
        }
        $kamis = [
            [
                'teacher_id' => 1,
                'course_id' => 2,
                'class_id' => 1,
                'day' => 'Kamis',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 13,
                'class_id' => 2,
                'day' => 'Kamis',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 3,
                'course_id' => 14,
                'class_id' => 3,
                'day' => 'Kamis',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 4,
                'course_id' => 6,
                'class_id' => 4,
                'day' => 'Kamis',
                'time' => 'Pagi'
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 15,
                'class_id' => 1,
                'day' => 'Kamis',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 15,
                'class_id' => 2,
                'day' => 'Kamis',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 15,
                'class_id' => 3,
                'day' => 'Kamis',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 15,
                'class_id' => 4,
                'day' => 'Kamis',
                'time' => 'Malam'
            ],
        ];
        foreach ($kamis as $data) {
            TrxSchedule::create($data);
        }

        $jumat = [
            [
                'teacher_id' => 1,
                'course_id' => 16,
                'class_id' => 1,
                'day' => 'Jumat',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 16,
                'class_id' => 2,
                'day' => 'Jumat',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 16,
                'class_id' => 3,
                'day' => 'Jumat',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 16,
                'class_id' => 4,
                'day' => 'Jumat',
                'time' => 'Pagi'
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 17,
                'class_id' => 1,
                'day' => 'Jumat',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 17,
                'class_id' => 2,
                'day' => 'Jumat',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 17,
                'class_id' => 3,
                'day' => 'Jumat',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 17,
                'class_id' => 4,
                'day' => 'Jumat',
                'time' => 'Malam'
            ],
        ];
        foreach ($jumat as $data) {
            TrxSchedule::create($data);
        }
        $sabtu = [
            [
                'teacher_id' => 1,
                'course_id' => 8,
                'class_id' => 1,
                'day' => 'Sabtu',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 18,
                'class_id' => 2,
                'day' => 'Sabtu',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 3,
                'course_id' => 19,
                'class_id' => 3,
                'day' => 'Sabtu',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 3,
                'course_id' => 19,
                'class_id' => 4,
                'day' => 'Sabtu',
                'time' => 'Pagi'
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 20,
                'class_id' => 1,
                'day' => 'Sabtu',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 20,
                'class_id' => 2,
                'day' => 'Sabtu',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 20,
                'class_id' => 3,
                'day' => 'Sabtu',
                'time' => 'Malam'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 20,
                'class_id' => 4,
                'day' => 'Sabtu',
                'time' => 'Malam'
            ],
        ];
        foreach ($sabtu as $data) {
            TrxSchedule::create($data);
        }

        //SETORAN
        $setorSenin = [
            [
                'teacher_id' => 1,
                'course_id' => 21,
                'class_id' => 1,
                'day' => 'Senin',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 21,
                'class_id' => 2,
                'day' => 'Senin',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 21,
                'class_id' => 3,
                'day' => 'Senin',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 21,
                'class_id' => 4,
                'day' => 'Senin',
                'time' => 'Pagi'
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Senin',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Senin',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Senin',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Senin',
                'time' => 'Sore'
            ],
        ];
        foreach ($setorSenin as $data) {
            TrxSchedule::create($data);
        }
        $setorSelasa = [
            [
                'teacher_id' => 1,
                'course_id' => 21,
                'class_id' => 1,
                'day' => 'Selasa',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 21,
                'class_id' => 2,
                'day' => 'Selasa',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 21,
                'class_id' => 3,
                'day' => 'Selasa',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 21,
                'class_id' => 4,
                'day' => 'Selasa',
                'time' => 'Pagi'
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Selasa',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Selasa',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Selasa',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Selasa',
                'time' => 'Sore'
            ],
        ];
        foreach ($setorSelasa as $data) {
            TrxSchedule::create($data);
        }
        $setorRabu = [
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Rabu',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Rabu',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Rabu',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Rabu',
                'time' => 'Pagi'
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Rabu',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Rabu',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Rabu',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Rabu',
                'time' => 'Sore'
            ],
        ];
        foreach ($setorRabu as $data) {
            TrxSchedule::create($data);
        }
        $setorKamis = [
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Kamis',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Kamis',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Kamis',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Kamis',
                'time' => 'Pagi'
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Kamis',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Kamis',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Kamis',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Kamis',
                'time' => 'Sore'
            ],
        ];
        foreach ($setorKamis as $data) {
            TrxSchedule::create($data);
        }
        $setorJumat = [
            [
                'teacher_id' => 1,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Jumat',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Jumat',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Jumat',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Jumat',
                'time' => 'Pagi'
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 24,
                'class_id' => 1,
                'day' => 'Jumat',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 24,
                'class_id' => 2,
                'day' => 'Jumat',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 24,
                'class_id' => 3,
                'day' => 'Jumat',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 24,
                'class_id' => 4,
                'day' => 'Jumat',
                'time' => 'Sore'
            ],
        ];
        foreach ($setorJumat as $data) {
            TrxSchedule::create($data);
        }
        $setorSabtu = [
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Sabtu',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Sabtu',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Sabtu',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Sabtu',
                'time' => 'Pagi'
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Sabtu',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Sabtu',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Sabtu',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Sabtu',
                'time' => 'Sore'
            ],
        ];
        foreach ($setorSabtu as $data) {
            TrxSchedule::create($data);
        }
        $setorAhad = [
            [
                'teacher_id' => 1,
                'course_id' => 23,
                'class_id' => 1,
                'day' => 'Ahad',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 23,
                'class_id' => 2,
                'day' => 'Ahad',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 23,
                'class_id' => 3,
                'day' => 'Ahad',
                'time' => 'Pagi'
            ],
            [
                'teacher_id' => 1,
                'course_id' => 23,
                'class_id' => 4,
                'day' => 'Ahad',
                'time' => 'Pagi'
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Ahad',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Ahad',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Ahad',
                'time' => 'Sore'
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Ahad',
                'time' => 'Sore'
            ],
        ];
        foreach ($setorAhad as $data) {
            TrxSchedule::create($data);
        }
    }
}
