<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = [
        'description',
        'picture',
        'max_participants',
        'description_price',
        'description_details',
        'template_welcome_mail',
        'template_confirmation_mail',
        'amount',
        'participant_type',
        'date_register_from',
        'date_register_to',
        'date_from',
        'date_to',
        't_rule_type_id',
        'currency_id',
        't_categories_id',
        't_category_types_id',
    ];

        /**
     * The professions that belong to the person.
     */
    public function payments()
    {
        return $this->belongsToMany('App\TPaymentMethod', 'tournament_t_payment_methods', 'tournament_id', 't_payment_methods_id');
    }

            /**
     * The professions that belong to the person.
     */
    public function groups()
    {
        return $this->belongsToMany('App\TCategoriesGroup', 't_category_groups__tournaments', 'tournament_id', 't_categories_groups_id');
    }


    /**
     * The sports that belong to the share.
     */
    public function rules()
    {
        return $this->hasOne('App\TRuleType', 'id', 't_rule_type_id');
    }

        /**
     * The sports that belong to the share.
     */
    public function currency()
    {
        return $this->hasOne('App\Currency', 'id', 'currency_id');
    }
}
