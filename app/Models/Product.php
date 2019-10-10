<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    //
    protected $guarded = [];

    public function getImageAttribute($value)
    {
        if ($value)
        {
            return asset(Storage::url($value));
        }
    }

    public function image()
    {
        return $this->hasMany('App\Models\ProductImage');
    }

    public function user(){

        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function subcategory(){
        return $this->belongsTo('App\Models\SubCategory', 'sub_category_id');
    }

    public function has_favorite($id)
    {
        if (Favorite::where('product_id', $this->id)->where('user_id',$id)->first())
        {
            return true;
        }
        return false;
    }

    public function pinned()
    {
        if($this->pinned == 2){
            return true;
        }
        return false;
    }

    public function bill()
    {
        if($this->bill == 2){
            return true;
        }
        return false;
    }

    public function msg()
    {
        if($this->msg == 2){
            return true;
        }
        return false;
    }

    public function video()
    {
        if($this->video == 2){
            return true;
        }
        return false;
    }

    public function repost()
    {
        if($this->repost == 2){
            return true;
        }
        return false;
    }
}
