<?php

namespace Database\Seeders;

use App\Models\MasterPayment;
use Illuminate\Database\Seeder;

class MasterPaymentSeeder extends Seeder
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
                'payment_name' => 'SPP',
                'total' => '1000000',
                'method' => 'TRANSFER BANK',
                'payment_number' => '983298392',
                'media_payment' => 'BCA'
            ]
        ];

        foreach ($data as $value) {
            MasterPayment::create($value);
        }
    }
}
