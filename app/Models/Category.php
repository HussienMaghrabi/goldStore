<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $guarded = [];

    public function category(){

        return $this->hasMany('App\Models\SubCategory', 'category_id');
    }
}
