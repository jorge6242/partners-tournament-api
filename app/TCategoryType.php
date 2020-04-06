<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TCategoryType extends Model
{
    protected $fillable = [
        'description',
        'status',
    ];
}
