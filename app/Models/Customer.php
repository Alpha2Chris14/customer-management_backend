<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'firstname',
        'lastname',
        'telephone',
        'bvn',
        'dob',
        'residential_address',
        'state',
        'bankcode',
        'accountnumber',
        'company_id',
        'email',
        'city',
        'country',
        'id_card',
        'voters_card',
        'drivers_licence'
    ];
}
