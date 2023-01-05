<?php

namespace Database\Seeders;

use App\Models\TrxPayment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class TrxPaymentSeeder extends Seeder
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
                'id_user' => 2,
                'id_payment' => 1,
                'id_student' => 1,
                'date_payment' => Date::now(),
                'status' => false,
                'total' => '500000'
            ]
        ];

        foreach ($data as $value) {
            TrxPayment::create($value);
        }
    }
}
