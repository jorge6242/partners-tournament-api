<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TCategory extends Model
{
    protected $fillable = [
        'description',
        'image',
        'status',
        'picture',
        't_category_type_id',
    ];


    public function type()
    {
        return $this->hasOne('App\TCategoryType', 'id', 't_category_type_id');
    }
}
