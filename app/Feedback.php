<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'title', 'description', 'answer', 'status'
    ];

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function managers()
    {
        return $this->belongsTo('App\Manager', 'seller_id');
    }
}
