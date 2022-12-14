<?php

namespace Database\Seeders;

use App\Models\MasterTeacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class PengajarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pengajar = [
            [
                'noId' => '1280128102',
                'email' => 'ahmad@gmail.com',
                'name' => 'Ahmad Agung',
                'photo' => null,
                'gender' => 'Laki-Laki',
                'province_id' => 3,
                'city_id' => 59,
                'date_birth' => Date::now(),
                'no_tlp' => '12198291',
                'address' => 'Lorem Ipsum'
            ],
            [
                'noId' => '1280128102',
                'email' => 'akbar@gmail.com',
                'name' => 'Ahmad Akbar',
                'photo' => null,
                'gender' => 'Laki-Laki',
                'province_id' => 3,
                'city_id' => 59,
                'date_birth' => Date::now(),
                'no_tlp' => '12198291',
                'address' => 'Lorem Ipsum'
            ],
            [
                'noId' => '1280128102',
                'email' => 'udin@gmail.com',
                'name' => 'Ahmad Udin',
                'photo' => null,
                'gender' => 'Laki-Laki',
                'province_id' => 3,
                'city_id' => 59,
                'date_birth' => Date::now(),
                'no_tlp' => '12198291',
                'address' => 'Lorem Ipsum'
            ],
        ];

        foreach ($pengajar as $data) {
            MasterTeacher::create($data);
        }
    }
}
