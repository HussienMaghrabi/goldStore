<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    //
    protected $guarded = [];

    public function product(){
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
