<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill_Product extends Model
{
    public function bills()
    {
        return $this->belongsTo('App\Bill', 'bill_id');
    }

    public function products()
    {
        return $this->belongsTo('App\Product', 'pro_id');
    }
}
