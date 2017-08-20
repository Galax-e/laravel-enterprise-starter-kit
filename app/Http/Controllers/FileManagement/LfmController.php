<?php namespace App\Http\Controllers\FileManagement;

use Unisharp\Laravelfilemanager\traits\LfmHelpers;
use Illuminate\Http\Request;

use App\Models\AppModels\Activity;
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
        $shared   = '%shared%';
        // $comment  = '%Comment%';
        $creation = '%created%';

        // $reg_activities = DB::table('activities')->whereNotNull('activity')
        // ->orWhere(function($query){
        //     $query->where('activity', 'like', '%created%')
        //         ->where('activity', 'like', '%shared%')
        //         ->where('activity', '<>', '');
        // })->distinct()->orderBy('created_at', 'desc')->take(50)->skip(10)->get();

        $reg_activities = DB::select('select distinct * from activities 
        where activity is not null and activity != ? and (activity like ? or activity like ?) 
        order by created_at desc limit 5', 
        ['', $shared, $creation]);


        $activities = DB::select('select distinct * from activities 
        where activity is not null and activity != ? and activity like ? 
        order by created_at desc limit 5', 
        ['', '%Forward%']);
        
        // $activities = DB::table('activities')->whereNotNull('activity')
        // ->orWhere(function($query){
        //     $query->where('activity', 'like', '%Forward%')
        //         ->where('activity', '<>', '');
        // })->distinct()->orderBy('created_at', 'desc')->take(50)->skip(10)->get();
        
        //$activities = DB::select('select * from activities where activity like ? order by created_at desc limit 5', [$activity]);
		
        if($request->ajax()){

            $folder_no = request('item_name');
            $folder = DB::select('select id from folders where folder_no = ?', [$folder_no]);
            $folder_id = 0;
            foreach($folder as $fid){
                $folder_id = ((array) $fid)["id"];
            }

            $activities = DB::table('activities')->whereNotNull(['activity', 'activity_to', 'activity_by'])
                ->orWhere(function($query){
                    $query->where('activity', '<>', '')
                        ->where('activity_to', '<>', '')
                        ->where('activity_by', '<>', '');
                })->get();

            //$activities = DB::select('select * from activities');
            $data = array();
            foreach($activities as $activity){

                if( ((array)$activity)["element_id"] == $folder_id){
                    $data[] = $activity;
                }
            }
            return response()->json($data);
        }	

        $forward_to_users = DB::select('select * from users');
        
        
        Flash::success('Welcome! Registry File Management Area.');
        return view('registry.index', compact('page_description', 'forward_to_users', 'page_title', 'activities', 'reg_activities'));
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
