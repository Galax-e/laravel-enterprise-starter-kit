<?php namespace App\Http\Controllers\FileManagement;

use Unisharp\Laravelfilemanager\traits\LfmHelpers;
use Illuminate\Http\Request;


use App\activity;
use DB;
use Flash;
/**
 * Class LfmController
 */
class LfmController extends Controller
{
    use LfmHelpers;

    protected static $success_response = 'OK';

    public function __construct()
    {
        $this->applyIniOverrides();
    }

    /**
     * Show the filemanager
     *
     * @return mixed
     */
    public function show(Request $request)
    {
        $page_title = trans('general.text.welcome');
        $page_description = "Registry Area";
		$activities = DB::select('select * from activities');

        if($request->ajax()){

            $data = array();
            foreach($activities as $activity){
                $data[] = $activity;
            }
            return response()->json($data);
        }	
        
        Flash::success('Welcome! Registry File Management Area.');
        return view('registry.index', compact('page_description', 'page_title', 'activities'));
    }

    public function getErrors()
    {
        $arr_errors = [];

        if (! extension_loaded('gd') && ! extension_loaded('imagick')) {
            // array_push($arr_errors, trans('laravel-filemanager::lfm.message-extension_not_found'));
            array_push($arr_errors, trans('registry/lfm.message-extension_not_found'));

        }

        $type_key = $this->currentLfmType();
        $mine_config = 'lfm.valid_' . $type_key . '_mimetypes';
        $config_error = null;

        if (!is_array(config($mine_config))) {
            array_push($arr_errors, 'Config : ' . $mine_config . ' is not a valid array.');
        }

        return $arr_errors;
    }
}
