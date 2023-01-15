<?php

namespace Database\Seeders;

use App\Models\TrxStudentPermits;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class PerizinanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permit = [
            [
                'student_id' => 1,
                'description' => 'Izin taklim, untuk mengerjakan tugas',
                'permit_date' => Date::now(),
                'permit_type' => 'TAKLIM',
                'id_program' => 2,

            ],
            [
                'student_id' => 2,
                'description' => 'Izin taklim, untuk mengerjakan tugas',
                'permit_date' => Date::now(),
                'permit_type' => 'TAKLIM',
                'id_program' => 2
            ],
        ];
        foreach ($permit as $data) {
            TrxStudentPermits::create($data);
        }
    }
}
