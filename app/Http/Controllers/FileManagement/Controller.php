<?php namespace App\Http\Controllers\FileManagement;

use Illuminate\Foundation\Bus\DispatchesJobs;
// use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller as AppController;

abstract class Controller extends AppController
{
    use DispatchesJobs, ValidatesRequests;
}
