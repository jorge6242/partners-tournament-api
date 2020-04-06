<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TCategoryGroups_Tournament extends Model
{
    protected $fillable = [
        'tournament_id',
        't_categories_groups_id',
    ];
}
