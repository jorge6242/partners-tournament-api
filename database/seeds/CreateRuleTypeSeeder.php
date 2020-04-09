<?php

use App\TRuleType;
use Illuminate\Database\Seeder;

class CreateRuleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Tipo Regla 1', 'slug' => 'tipo-regla-1' ],
            [ 'description' => 'Tipo Regla 2', 'slug' => 'tipo-regla-2' ],
            [ 'description' => 'Tipo Regla 3', 'slug' => 'tipo-regla-3' ],
        ];
        foreach ($data as $element) {
            TRuleType::create([
                'description' => $element['description'],
                'slug' => $element['slug'],
            ]);
        }
    }
}
