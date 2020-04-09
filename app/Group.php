<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'attach_file',
        'balance',
        'balancer_date',
        'is_suspended',
        'is_active',
    ];
}
