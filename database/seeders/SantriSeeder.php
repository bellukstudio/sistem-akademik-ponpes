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
                'phone' => '293829320',
                'program_id' => '2',
                'is_activate' => 1
            ],
            [
                'noId' => '82371284',
                'email' => 'bellukchips@gmail.com',
                'name' => 'Akbar',
                'photo' => null,
                'gender' => 'Laki-Laki',
                'address' => 'Slawi',
                'province_id' => 1,
                'city_id' => 1,
                'date_birth' => Date::now(),
                'phone' => '293829320',
                'program_id' => '2',
            ],
            [
                'noId' => '823712824',
                'email' => 'lukman@gmail.com',
                'name' => 'Lukman Akbar',
                'photo' => null,
                'gender' => 'Laki-Laki',
                'address' => 'Slawi',
                'province_id' => 1,
                'city_id' => 1,
                'date_birth' => Date::now(),
                'phone' => '293829320',
                'program_id' => '2',
            ],
            [
                'noId' => '8223712824',
                'email' => 'akbar@gmail.com',
                'name' => 'Zainal Akbar',
                'photo' => null,
                'gender' => 'Laki-Laki',
                'address' => 'Slawi',
                'province_id' => 1,
                'city_id' => 1,
                'date_birth' => Date::now(),
                'phone' => '293829320',
                'program_id' => '1',
            ],
        ];

        foreach ($santri as $data) {
            MasterStudent::create($data);
        }
    }
}
