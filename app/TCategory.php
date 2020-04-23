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
    ];
}
