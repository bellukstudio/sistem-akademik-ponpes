<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MasterUsersSeeder::class,
            BeritaSeeder::class,
            ProvinsiSeeder::class,
            KotaSeeder::class
        ]);
    }
}
