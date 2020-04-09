<?php

use App\TPaymentMethod;
use Illuminate\Database\Seeder;

class CreateTPaymentMethodSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Metodo de Pago 1', 'info' => 'Metodo de Pago 1', 'status' => 1, 'currency_id' => null ],
            [ 'description' => 'Metodo de Pago 2', 'info' => 'Metodo de Pago 2', 'status' => 1, 'currency_id' => null ],
            [ 'description' => 'Metodo de Pago 3', 'info' => 'Metodo de Pago 3', 'status' => 1, 'currency_id' => null ],
        ];
        foreach ($data as $element) {
            TPaymentMethod::create([
                'description' => $element['description'],
                'info' => $element['info'],
                'status' => $element['status'],
                'currency_id' => $element['currency_id'],
            ]);
        }
    }
}
