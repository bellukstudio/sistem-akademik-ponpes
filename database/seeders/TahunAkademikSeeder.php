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
                'status' => false,
                'information' => 'GENAP'
            ],
            [
                'code' => '2018/2019',
                'status' => false,
                'information' => 'GANJIL'
            ],
            [
                'code' => '2021/2022',
                'status' => false,
                'information' => 'GENAP'
            ],
            [
                'code' => '2022/2023',
                'status' => true,
                'information' => 'GANJIL'
            ],
        ];

        foreach ($period as $data) {
            MasterPeriod::create($data);
        }
    }
}
