<?php

namespace Database\Seeders;

use App\Models\MasterPicket;
use Illuminate\Database\Seeder;

class JadwalPiketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            [
                'name' => 'MASAK',
            ],
            [
                'name' => 'KEBERSIHAN',
            ]
        ];

        foreach ($category as $data) {
            MasterPicket::create($data);
        }
    }
}
