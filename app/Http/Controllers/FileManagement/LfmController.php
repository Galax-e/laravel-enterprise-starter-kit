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

        $activity = '%Forward%';
        $comment  = '%Comment%';
        $creation = '%created%';
        $activities = DB::select('select * from activities where activity like ? or activity like ? or activity like ?  order by created_at desc limit 5', [$activity, $comment, $creation]);
		
        if($request->ajax()){

            $folder_no = request('item_name');
            $folder = DB::select('select id from folders where folder_no = ?', [$folder_no]);
            $folder_id = 0;
            foreach($folder as $fid){
                $folder_id = ((array) $fid)["id"];
            }

            $activities = DB::select('select * from activities');
            $data = array();
            foreach($activities as $activity){

                if( ((array)$activity)["element_id"] == $folder_id){
                    $data[] = $activity;
                }
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
