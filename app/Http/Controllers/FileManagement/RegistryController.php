<?php

namespace App\Http\Controllers\FileManagement;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RegistryController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // $this->dir = base_path("public/docs/files/1");
    }

    public function viewAll(Request $request)
    {
        
        return "Hello Registry";
    }
    
}



