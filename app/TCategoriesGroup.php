<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TCategoriesGroup extends Model
{
    protected $fillable = [
        'description',
        'age_from',
        'age_to',
        'gender_id',
        'golf_handicap_from',
        'golf_handicap_to',
        'category_id',
    ];
}
