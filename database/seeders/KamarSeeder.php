<?php

namespace Database\Seeders;

use App\Models\MasterRoom;
use Illuminate\Database\Seeder;

class KamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kamar = [
            [
                'room_name' => 'Kamar A',
                'capasity' => '20',
                'type' => 'KAMAR'
            ],
            [
                'room_name' => 'Kamar B',
                'capasity' => '20',
                'type' => 'KAMAR'
            ],
            [
                'room_name' => 'Kamar C',
                'capasity' => '20',
                'type' => 'KAMAR'
            ],
            [
                'room_name' => 'Kamar D',
                'capasity' => '20',
                'type' => 'KAMAR'
            ],
            [
                'room_name' => 'Kamar E',
                'capasity' => '20',
                'type' => 'KAMAR'
            ],
        ];

        foreach ($kamar as $data) {
            MasterRoom::create($data);
        }
    }
}
