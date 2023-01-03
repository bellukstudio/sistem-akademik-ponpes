<?php

namespace Database\Seeders;

use App\Models\TrxRoomGroup;
use Illuminate\Database\Seeder;

class KelompokKamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $room = [
            [
                'room_id' => 1,
                'student_id' => 2,
            ],
            [
                'room_id' => 2,
                'student_id' => 1,
            ],

        ];

        foreach ($room as $data) {
            TrxRoomGroup::create($data);
        }
    }
}
