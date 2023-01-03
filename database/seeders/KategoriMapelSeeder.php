<?php

namespace Database\Seeders;

use App\Models\MasterCategorieSchedule;
use Illuminate\Database\Seeder;

class KategoriMapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'categorie_name' => 'SETORAN'
            ],
            [
                'categorie_name' => 'TAKLIM'
            ],
        ];

        foreach ($data as $item) {
            MasterCategorieSchedule::create($item);
        }
    }
}
