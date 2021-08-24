<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    //

    protected $fillable =
         [
             'first_name',
             'last_name',
             'Country',
             'gender',
             'date_of_birth',
             'photo',
             'hobbies',
             'history',
             'support_amount',
             'frequency',
             'household_id'
         ];

    public function household(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Household');
    }
}
