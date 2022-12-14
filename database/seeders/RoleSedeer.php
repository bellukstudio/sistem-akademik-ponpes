<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RoleSedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            [
                'name' => 'Admin'
            ],
            [
                'name' => 'Pengajar'
            ],
            [
                'name' => 'Pengurus'
            ],
            [
                'name' => 'Santri'
            ],
        ];
        foreach ($role as $data) {
            Roles::create($data);
        }
    }
}
