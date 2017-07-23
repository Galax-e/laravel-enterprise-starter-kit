<?php namespace App\Http\Controllers\FileManagement;

/**
 * Class DemoController
 * @package Unisharp\Laravelfilemanager\controllers
 */
class DemoController extends LfmController
{

    /**
     * @return mixed
     */
    public function index()
    {
        return view('registry.demo');
    }
}
