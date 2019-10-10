<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    //

    use SoftDeletes;

    protected $guarded = [];

    public function setPasswordAttribute($password){

        if(!empty($password)){

            $this->attributes['password'] = bcrypt($password);
        }
    }

    public function getImageAttribute($value)
    {
        if ($value)
        {
            return asset(Storage::url($value));
        }
    }


    public function product(){

        return $this->hasMany('App\Models\Product', 'user_id');
    }

    public function sender(){

        return $this->hasMany('App\Models\Message', 'sender_id');
    }
}
