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
                'time' => 'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 1,
                'class_id' => 2,
                'day' => 'Ahad',
                'time' => 'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 1,
                'class_id' => 3,
                'day' => 'Ahad',
                'time' => 'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 1,
                'class_id' => 4,
                'day' => 'Ahad',
                'time' => 'Pagi',
                'id_period' => 4
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 2,
                'class_id' => 1,
                'day' => 'Ahad',
                'time' => 'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 3,
                'course_id' => 3,
                'class_id' => 2,
                'day' => 'Ahad',
                'time' => 'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 3,
                'class_id' => 3,
                'day' => 'Ahad',
                'time' => 'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 4,
                'course_id' => 3,
                'class_id' => 4,
                'day' => 'Ahad',
                'time' => 'Malam',
                'id_period' => 4
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
                'time' => 'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 4,
                'class_id' => 2,
                'day' => 'Senin',
                'time' => 'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 4,
                'class_id' => 3,
                'day' => 'Senin',
                'time' => 'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 4,
                'class_id' => 4,
                'day' => 'Senin',
                'time' => 'Pagi',
                'id_period' => 4
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 5,
                'class_id' => 1,
                'day' => 'Senin',
                'time' => 'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 3,
                'course_id' => 2,
                'class_id' => 2,
                'day' => 'Senin',
                'time' => 'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 6,
                'class_id' => 3,
                'day' => 'Senin',
                'time' => 'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 4,
                'course_id' => 7,
                'class_id' => 4,
                'day' => 'Senin',
                'time' => 'Malam',
                'id_period' => 4
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
                'time' => 'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 4,
                'class_id' => 2,
                'day' => 'Selasa',
                'time' => 'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 4,
                'class_id' => 3,
                'day' => 'Selasa',
                'time' => 'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 4,
                'class_id' => 4,
                'day' => 'Selasa',
                'time' => 'Pagi',
                'id_period' => 4
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 8,
                'class_id' => 1,
                'day' => 'Selasa',
                'time' => 'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 3,
                'course_id' => 9,
                'class_id' => 2,
                'day' => 'Selasa',
                'time' => 'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 10,
                'class_id' => 3,
                'day' => 'Selasa',
                'time' => 'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 4,
                'course_id' => 6,
                'class_id' => 4,
                'day' => 'Selasa',
                'time' => 'Malam',
                'id_period' => 4
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
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 25,
                'class_id' => 2,
                'day' => 'Rabu',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 25,
                'class_id' => 3,
                'day' => 'Rabu',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 25,
                'class_id' => 4,
                'day' => 'Rabu',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 11,
                'class_id' => 1,
                'day' => 'Rabu',
                'time' => 'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 3,
                'course_id' => 10,
                'class_id' => 2,
                'day' => 'Rabu',
                'time' =>
                'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 6,
                'class_id' => 3,
                'day' => 'Rabu',
                'time' =>
                'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 4,
                'course_id' => 12,
                'class_id' => 4,
                'day' => 'Rabu',
                'time' =>
                'Malam',
                'id_period' => 4
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
                'time' => 'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 13,
                'class_id' => 2,
                'day' => 'Kamis',
                'time' => 'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 3,
                'course_id' => 14,
                'class_id' => 3,
                'day' => 'Kamis',
                'time' => 'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 4,
                'course_id' => 6,
                'class_id' => 4,
                'day' => 'Kamis',
                'time' => 'Pagi',
                'id_period' => 4
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 15,
                'class_id' => 1,
                'day' => 'Kamis',
                'time' => 'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 15,
                'class_id' => 2,
                'day' => 'Kamis',
                'time' => 'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 15,
                'class_id' => 3,
                'day' => 'Kamis',
                'time' => 'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 15,
                'class_id' => 4,
                'day' => 'Kamis',
                'time' => 'Malam',
                'id_period' => 4
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
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 16,
                'class_id' => 2,
                'day' => 'Jumat',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 16,
                'class_id' => 3,
                'day' => 'Jumat',
                'time' => 'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 16,
                'class_id' => 4,
                'day' => 'Jumat',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 17,
                'class_id' => 1,
                'day' => 'Jumat',
                'time' =>
                'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 17,
                'class_id' => 2,
                'day' => 'Jumat',
                'time' =>
                'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 17,
                'class_id' => 3,
                'day' => 'Jumat',
                'time' =>
                'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 17,
                'class_id' => 4,
                'day' => 'Jumat',
                'time' =>
                'Malam',
                'id_period' => 4
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
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 18,
                'class_id' => 2,
                'day' => 'Sabtu',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 3,
                'course_id' => 19,
                'class_id' => 3,
                'day' => 'Sabtu',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 3,
                'course_id' => 19,
                'class_id' => 4,
                'day' => 'Sabtu',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 20,
                'class_id' => 1,
                'day' => 'Sabtu',
                'time' =>
                'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 20,
                'class_id' => 2,
                'day' => 'Sabtu',
                'time' =>
                'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 20,
                'class_id' => 3,
                'day' => 'Sabtu',
                'time' =>
                'Malam',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 20,
                'class_id' => 4,
                'day' => 'Sabtu',
                'time' =>
                'Malam',
                'id_period' => 4
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
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 21,
                'class_id' => 2,
                'day' => 'Senin',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 21,
                'class_id' => 3,
                'day' => 'Senin',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 21,
                'class_id' => 4,
                'day' => 'Senin',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Senin',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Senin',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Senin',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Senin',
                'time' =>
                'Sore',
                'id_period' => 4
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
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 21,
                'class_id' => 2,
                'day' => 'Selasa',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 21,
                'class_id' => 3,
                'day' => 'Selasa',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 21,
                'class_id' => 4,
                'day' => 'Selasa',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Selasa',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Selasa',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Selasa',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Selasa',
                'time' =>
                'Sore',
                'id_period' => 4
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
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Rabu',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Rabu',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Rabu',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Rabu',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Rabu',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Rabu',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Rabu',
                'time' =>
                'Sore',
                'id_period' => 4
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
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Kamis',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Kamis',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Kamis',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Kamis',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Kamis',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Kamis',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Kamis',
                'time' =>
                'Sore',
                'id_period' => 4
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
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Jumat',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Jumat',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Jumat',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 24,
                'class_id' => 1,
                'day' => 'Jumat',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 24,
                'class_id' => 2,
                'day' => 'Jumat',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 24,
                'class_id' => 3,
                'day' => 'Jumat',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 24,
                'class_id' => 4,
                'day' => 'Jumat',
                'time' =>
                'Sore',
                'id_period' => 4
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
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Sabtu',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Sabtu',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Sabtu',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Sabtu',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Sabtu',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Sabtu',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Sabtu',
                'time' =>
                'Sore',
                'id_period' => 4
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
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 23,
                'class_id' => 2,
                'day' => 'Ahad',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 23,
                'class_id' => 3,
                'day' => 'Ahad',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            [
                'teacher_id' => 1,
                'course_id' => 23,
                'class_id' => 4,
                'day' => 'Ahad',
                'time' =>
                'Pagi',
                'id_period' => 4
            ],
            // malam
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 1,
                'day' => 'Ahad',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 2,
                'day' => 'Ahad',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 3,
                'day' => 'Ahad',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
            [
                'teacher_id' => 2,
                'course_id' => 22,
                'class_id' => 4,
                'day' => 'Ahad',
                'time' =>
                'Sore',
                'id_period' => 4
            ],
        ];
        foreach ($setorAhad as $data) {
            TrxSchedule::create($data);
        }
    }
}
