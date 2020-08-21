<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $fillable = [
        'product_key', 'activation_date', 'expiration_date', 'pro_id', 'user_id', 'seller_id', 'bill_id'
    ];

    public function products()
    {
        return $this->belongsTo('App\Product', 'pro_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function managers()
    {
        return $this->belongsTo('App\Manager', 'seller_id');
    }
}
