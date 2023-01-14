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
                $email => 'sispendikapps@gmail.com',
                $password => Hash::make('adminponpes'),
                $roles => 1,
            ],
            [
                $name => 'Ahmad Agung',
                $email => 'sibelluk12@gmail.com',
                $password => Hash::make('20230111'),
                $roles => 2,
            ],

        ];
        foreach ($user as $data) {
            MasterUsers::create($data);
        }
    }
}
