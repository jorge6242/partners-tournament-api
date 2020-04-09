<?php

use App\TCategoriesGroup;
use Illuminate\Database\Seeder;

class CreateTCategoryGroupsSeeder extends Seeder
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
                'description' => 'Grupo 1', 
                'age_from' => 20, 
                'age_to' => 30, 
                'gender_id' => 1 ,
                'golf_handicap_from' => 1 ,
                'golf_handicap_to' => 1 ,
                'category_id' => 1,
            ],
            [ 
                'description' => 'Grupo 2', 
                'age_from' => 20, 
                'age_to' => 30, 
                'gender_id' => 1 ,
                'golf_handicap_from' => 1 ,
                'golf_handicap_to' => 1 ,
                'category_id' => 1,
            ],
            [ 
                'description' => 'Grupo 3', 
                'age_from' => 20, 
                'age_to' => 30, 
                'gender_id' => 1 ,
                'golf_handicap_from' => 1 ,
                'golf_handicap_to' => 1 ,
                'category_id' => 1,
            ],
        ];
        foreach ($data as $element) {
            TCategoriesGroup::create([
                'description' => $element['description'],
                'age_from' => $element['age_from'],
                'age_to' => $element['age_to'],
                'gender_id' => $element['gender_id'],
                'golf_handicap_from' => $element['golf_handicap_from'],
                'golf_handicap_to' => $element['golf_handicap_to'],
                'category_id' => $element['category_id'],
            ]);
        }
    }
}
