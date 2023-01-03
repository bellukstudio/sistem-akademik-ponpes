<?php

namespace Database\Seeders;

use App\Models\TrxClassGroup;
use Illuminate\Database\Seeder;

class KelompokKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $class = [
            [
                'student_id' => 1,
                'class_id' => 1
            ],
            [
                'student_id' => 2,
                'class_id' => 2
            ],
        ];

        foreach ($class as $data) {
            TrxClassGroup::create($data);
        }
    }
}
