<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'name_card', 'number_card', 'cvc', 'exp_month', 'exp_year', 'status','user_id'
    ];
}
