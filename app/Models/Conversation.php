<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    //
    protected $guarded = [];

    public function Message()
    {
        return $this->hasMany('App\Models\Message');
    }
}
