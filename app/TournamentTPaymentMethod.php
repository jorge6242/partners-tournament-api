<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TournamentTPaymentMethod extends Model
{
    protected $fillable = [
        'tournament_id',
        't_payment_methods_id',
    ];
}
