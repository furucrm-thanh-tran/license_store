<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name_pro', 'description_pro', 'icon_pro', 'price_license',
    ];

    public function bills()
    {
        return $this->belongsToMany('App\Bill', 'bill__products', 'pro_id', 'bill_id');
    }

    public function bill__products()
    {
        return $this->hasMany('App\Bill_Product');
    }
}
