<?php

namespace Database\Seeders;

use App\Models\MasterCourse;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mapel = [
            //taklim
            [
                'course_name' => 'MAJAS',
                'program_id' => 2,
                'category_id' => 2,
            ],
            [
                'course_name' => 'SAFINAH',
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => 'JUZ AMMA',
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => 'NGAJI ABAH',
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => "ARBA'IN FIL'ILM",
                'category_id' => 2,
                'program_id' => 2,
            ],
            [
                'course_name' => 'MUKHTASHOR SHOGHIR',
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => 'NURUL IMAN',
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => "ALQUR'AN DAN TAJWID",
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => 'HAID',
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => 'MUKHTAR HADITS',
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => 'AQIDATUL AWAM',
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => 'NGETIK MODUL FIQH',
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => 'HAFALAN WIRID',
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => 'HAFALAN MUKHTASHOR SHOGHIR',
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => 'MAULID',
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => 'KHITHOBIYAH',
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => 'TAHLIL/EVALUASI',
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => 'HAFALAN SAFINAH',
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => "ALQUR'AN",
                'program_id' => 2,
                'category_id' => 2,

            ],
            [
                'course_name' => "BAHASA ARAB",
                'program_id' => 2,
                'category_id' => 2,

            ],


            //setoran
            [
                'course_name' => "TAKLIM ABAH DAN SETORAN",
                'program_id' => 2,
                'category_id' => 1,
            ],
            [
                'course_name' => "SETORAN",
                'program_id' => 2,
                'category_id' => 1,
            ],
            [
                'course_name' => "MAJAS/SETORAN",
                'program_id' => 2,
                'category_id' => 1,
            ],
            [
                'course_name' => "BURDAH DAN SHALAWAT IBRAHIMIYAH",
                'program_id' => 2,
                'category_id' => 1,
            ],

            // new
            [
                'course_name' => "SENAM",
                'program_id' => 2,
                'category_id' => 2,

            ],
        ];
        foreach ($mapel as $data) {
            MasterCourse::create($data);
        }
    }
}
