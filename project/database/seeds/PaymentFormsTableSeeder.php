<?php

use Illuminate\Database\Seeder;

class PaymentFormsTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table("payment_forms")->insert([
            [
                "id"         => 1,
                "name"       => "Cheque",
            ],
            [
                "id"         => 2,
                "name"       => "Cartão de crédito",
            ],
            [
                "id"         => 3,
                "name"       => "Cartão de débito",
            ],
            [
                "id"         => 4,
                "name"       => "Boleto bancário",
            ],
            [
                "id"         => 5,
                "name"       => "À vista",
            ],
        ]);
    }
}
