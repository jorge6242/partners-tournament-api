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

    public function gender() {
        return $this->hasOne('App\Gender', 'id', 'gender_id');
    }

    public function category() {
        return $this->hasOne('App\TCategory', 'id', 'category_id');
    }
}
