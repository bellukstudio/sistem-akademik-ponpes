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
                'class_name' => 'HOLAQOH 1',
                'program_id' => 2,
            ],
            [
                'class_name' => 'HOLAQOH 2',
                'program_id' => 2,
            ],
            [
                'class_name' => 'HOLAQOH 3',
                'program_id' => 2,
            ],
            [
                'class_name' => 'HOLAQOH 4',
                'program_id' => 2,
            ],

        ];
        foreach ($kelas as $data) {
            MasterClass::create($data);
        }
    }
}
