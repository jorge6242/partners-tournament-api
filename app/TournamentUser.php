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
        'user_notes',
        'comments',
        'nro_comprobante',
        'canal_pago',
        'fec_pago',
        'winner',
        'fec_winnner',
    ];

    public function payment()
    {
        return $this->hasOne('App\TPaymentMethod', 'id', 't_payment_methods_id');
    }

    public function tournament()
    {
        return $this->hasOne('App\Tournament', 'id', 'tournament_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
