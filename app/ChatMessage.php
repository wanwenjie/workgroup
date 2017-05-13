<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    //
    protected $table = 'chat_messages';

    protected $fillable = ['message','group_id','user_id','name'];

}
