<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TPaymentMethod extends Model
{
    protected $fillable = [
        'description',
        'currency_id',
        'info',
        'status' 
    ];
}
