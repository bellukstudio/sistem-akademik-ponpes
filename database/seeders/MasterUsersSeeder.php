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
        $roles = 'roles';
        $user = [
            [
                $email => 'adminponpes@gmail.com',
                $password => Hash::make('adminponpes'),
                $roles => 1,
            ],
            [
                $email => 'lukman@gmail.com',
                $password => Hash::make('masuk123'),
                $roles => 2,
            ],
        ];
        foreach ($user as $data) {
            MasterUsers::create($data);
        }
    }
}
