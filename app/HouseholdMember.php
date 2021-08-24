<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseholdMember extends Model
{
    //
    protected $fillable = [
            'first_name',
            'last_name',
            'gender',
            'phone',
            'household_id',
            'household_head',
    ];
}
