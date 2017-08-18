<?php

namespace App\Models\AppModels;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    //

    protected $fillable = ['name', 'desc', 'registry', 'folder_by', 'agency_dept', 'folder_to', 'clearance_level', 'latest_doc', 'search_term'];
}
