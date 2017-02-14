<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $table = 'chat_messages';

    protected $fillable = ['id','email','message'];
    public function getNameUser($email){
        return User::where('email',$email)->first()->name;
    }
}
