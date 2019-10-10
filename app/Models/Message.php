<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $guarded = [];

    public function Conversation()
    {
        return $this->belongsTo('App\Models\Conversation');
    }


    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
}
