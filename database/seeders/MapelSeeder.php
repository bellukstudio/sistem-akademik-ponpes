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
            [
                'course_name' => 'BK',
                'program_id' => 1,
            ],
            [
                'course_name' => 'TP',
                'program_id' => 2,
            ],
        ];
        foreach ($mapel as $data) {
            MasterCourse::create($data);
        }
    }
}
