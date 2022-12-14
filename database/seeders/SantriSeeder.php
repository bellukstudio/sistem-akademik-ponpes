<?php

namespace Database\Seeders;

use App\Models\MasterStudent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class SantriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $santri = [
            [
                'noId' => '82371283',
                'email' => 'muhamadlukman937@gmail.com',
                'name' => 'Muh Lukman Akbar P',
                'photo' => null,
                'gender' => 'Laki-Laki',
                'address' => 'Slawi',
                'province_id' => 1,
                'city_id' => 1,
                'date_birth' => Date::now(),
                'student_parent' => 'Jhon Doe',
                'no_tlp' => '293829320',
                'program_id' => '1',
                'period_id' => '2'
            ],
            [
                'noId' => '82371283',
                'email' => 'myzee@gmail.com',
                'name' => 'Akbar',
                'photo' => null,
                'gender' => 'Laki-Laki',
                'address' => 'Slawi',
                'province_id' => 1,
                'city_id' => 1,
                'date_birth' => Date::now(),
                'student_parent' => 'Jhon Doe',
                'no_tlp' => '293829320',
                'program_id' => '1',
                'period_id' => '2'
            ],
        ];

        foreach ($santri as $data) {
            MasterStudent::create($data);
        }
    }
}