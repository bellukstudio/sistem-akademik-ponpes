<?php

namespace Database\Seeders;

use App\Models\TrxStudentPermits;
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
            RoleSedeer::class,
            MasterUsersSeeder::class,
            AbsenSeeder::class,
            ProgramSeeder::class,
            MapelSeeder::class,
            PerizinanSeeder::class,
            BeritaSeeder::class,
            ProvinsiSeeder::class,
            KotaSeeder::class,
            TahunAkademikSeeder::class,
            KamarSeeder::class,
            KelasSeeder::class,
            PengajarSeeder::class,
            RuangSeeder::class,
            SantriSeeder::class,
            JadwalSeeder::class,
            JadwalPiketSeeder::class
        ]);
    }
}
