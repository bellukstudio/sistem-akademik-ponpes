<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MasterUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_users')->insert([
            'email' => 'adminponpes@gmail.com',
            'password' => Hash::make('adminponpes'),
            'roles' => 1,
        ]);
    }
}
