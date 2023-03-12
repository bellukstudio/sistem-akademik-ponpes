<?php

namespace Database\Seeders;

use App\Models\MasterAssessment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriNilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'UTS',
                'program_id' => 2,
                'weight' => 0.30

            ],
            [
                'name' => 'UAS',
                'program_id' => 2,
                'weight' => 0.70
            ],
        ];

        foreach ($data as $item) {
            MasterAssessment::create($item);
        }
    }
}
