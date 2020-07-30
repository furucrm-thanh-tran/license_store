<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name_pro', 'description_pro', 'icon_pro', 'price_license',
    ];
}
