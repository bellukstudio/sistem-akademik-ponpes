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
                'class_name' => 'Kelas A'
            ],
            [
                'class_name' => 'Kelas B'
            ],
            [
                'class_name' => 'Kelas C'
            ],
            [
                'class_name' => 'Kelas D'
            ],
            [
                'class_name' => 'Kelas E'
            ],
        ];
        foreach ($kelas as $data) {
            MasterClass::create($data);
        }
    }
}
