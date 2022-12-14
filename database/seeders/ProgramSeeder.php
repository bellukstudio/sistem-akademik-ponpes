<?php

namespace Database\Seeders;

use App\Models\MasterAcademicProgram;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $program = [
            [
                'code' => 'TH1FZ',
                'program_name' => 'TAFHIZ'
            ],
            [
                'code' => 'KTB01',
                'program_name' => 'KITAB'
            ],

        ];

        foreach ($program as $data) {
            MasterAcademicProgram::create($data);
        }
    }
}
