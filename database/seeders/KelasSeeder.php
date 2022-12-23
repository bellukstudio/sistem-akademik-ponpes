<?php

namespace Database\Seeders;

use App\Models\MasterClass;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelas = [
            [
                'class_name' => 'Kelas A',
                'program_id' => 1,
            ],
            [
                'class_name' => 'Kelas B',
                'program_id' => 1,
            ],
            [
                'class_name' => 'Kelas C',
                'program_id' => 2,
            ],
            [
                'class_name' => 'Kelas D',
                'program_id' => 2,
            ],
            [
                'class_name' => 'Kelas E',
                'program_id' => 1,
            ],
        ];
        foreach ($kelas as $data) {
            MasterClass::create($data);
        }
    }
}
