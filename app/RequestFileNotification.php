<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestFileNotification extends Model
{
    //

    //
    protected $fillable = ['folder_request_id', 'sender_id', 'receiver_id'];

    protected $appends = ['sender', 'receiver'];
}
