<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    //
    protected $fillable = [
        'name',
        'phone_number',
        'country'
    ];

    public function members(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(HouseholdMember::class, 'household_id', 'id');
    }
}
