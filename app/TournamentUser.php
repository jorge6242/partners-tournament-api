<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TournamentUser extends Model
{
    protected $fillable = [
        'register_date',
        'attach_file',
        'confirmation_link',
        'status',
        'date_confirmed',
        'date_verified',
        'locator',
        'date_verified',
        'tournament_id',
        'user_id',
        't_payment_methods_id',
        't_categories_groups_id',
    ];
}
