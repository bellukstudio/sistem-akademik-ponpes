<?php

namespace Database\Seeders;

use App\Models\MasterUsers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasterUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'email';
        $password = 'password';
        $name = 'name';
        $roles = 'roles_id';
        $user = [
            [
                $name => 'admin',
                $email => 'adminponpes@gmail.com',
                $password => Hash::make('adminponpes'),
                $roles => 1,
            ],
            [
                $name => 'lukman',
                $email => 'lukman@gmail.com',
                $password => Hash::make('masuk123'),
                $roles => 2,
            ],
            [
                $name => 'akbar',

                $email => 'akbar@gmail.com',
                $password => Hash::make('masuk123'),
                $roles => 3,
            ],
            [
                $name => 'udin',
                $email => 'udin@gmail.com',
                $password => Hash::make('masuk123'),
                $roles => 4,
            ],
        ];
        foreach ($user as $data) {
            MasterUsers::create($data);
        }
    }
}
