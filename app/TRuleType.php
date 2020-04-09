<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TRuleType extends Model
{
    protected $fillable = [
        'description',
        'slug',
    ];
}
