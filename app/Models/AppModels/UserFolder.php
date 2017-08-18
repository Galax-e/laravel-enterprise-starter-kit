<?php

namespace App\Models\AppModels;

use Illuminate\Database\Eloquent\Model;

class UserFolder extends Model
{
    //
    protected $fillable = ['user_id', 'passer_id', 'folder_id'];
}
