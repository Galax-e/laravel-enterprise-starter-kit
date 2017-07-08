<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemoNotification extends Model
{
    //

    protected $fillable = ['memo_id', 'sender_id', 'receiver_id'];

    protected $appends = ['sender', 'receiver'];
}
