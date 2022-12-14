<?php

namespace Database\Seeders;

use App\Models\MasterPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class TahunAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $period = [
            [
                'code' => '2019/2020',
                'start_date' => Date::now(),
                'end_date' => Date::now(),
            ],
            [
                'code' => '2018/2019',
                'start_date' => Date::now(),
                'end_date' => Date::now(),
            ],
            [
                'code' => '2021/2022',
                'start_date' => Date::now(),
                'end_date' => Date::now(),
            ],
        ];

        foreach ($period as $data) {
            MasterPeriod::create($data);
        }
    }
}
