<?php

namespace Database\Seeders;

use App\Models\MasterRoom;
use Illuminate\Database\Seeder;

class RuangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ruang = [
            [
                'room_name' => 'Ruang A',
                'capasity' => '100',
                'type' => 'RUANGAN',
                'photo' => null
            ],
            [
                'room_name' => 'Ruang B',
                'capasity' => '100',
                'type' => 'RUANGAN',
                'photo' => null
            ],
            [
                'room_name' => 'Ruang B',
                'capasity' => '100',
                'type' => 'RUANGAN',
                'photo' => null
            ],
        ];

        foreach ($ruang as $data) {
            MasterRoom::create($data);
        }
    }
}
