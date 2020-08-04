<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function managers()
    {
        return $this->belongsTo('App\Manager', 'seller_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'bill__products', 'bill_id', 'pro_id');
    }

    public function bill__products()
    {
        return $this->hasMany('App\Bill_Product', 'bill_id');
    }
}
