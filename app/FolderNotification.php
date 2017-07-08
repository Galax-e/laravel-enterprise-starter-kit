<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FolderNotification extends Model
{
    //
    protected $fillable = ['folder_id', 'sender_id', 'receiver_id'];

    protected $appends = ['sender', 'receiver'];

}
