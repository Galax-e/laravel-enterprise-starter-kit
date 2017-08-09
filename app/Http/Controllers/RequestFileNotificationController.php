<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\RequestFileNotification;
use DB;
use Auth;

class RequestFileNotificationController extends Controller
{

    /**
    * Fetch Memo notification
    *
    */
    public function fetch(Request $request){

        $user = Auth::user();
        //$notif_count = DB::select('select count(*) from folder_notifications where status=0');
        
        $file_request_count = RequestFileNotification::where('receiver_roles', '>', 1)
            ->where('status', '=', 0)
            ->orderBy('created_at', 'desc')
            ->count();
        
        $data = array('user'=>$user, 'file_request_count' => $file_request_count, 'user_role'=>Auth::user()->roles->count() );
        return response()->json($data);
    }

    // user has seen notification, turn status to 1
    public function notificationseen(Request $request)
    {
        $receiver_roles =  Auth::user()->roles->count();
        
        $status = 0;
        $notifications = DB::select('select * from request_file_notifications where receiver_roles = ? and status = ?', [$receiver_roles, $status]);

        foreach($notifications as $notification){
            $notif_id = ((array) $notification)["id"];

            DB::update('update request_file_notifications set status = ? where id = ?', [1, $notif_id]);
        }

        return response()->json((array) $notifications); //redirect()->back();
    }

    public function seenFolderReq(Request $request){

        $request_folder_id = request('folder_req_id');

        DB::update('update folder_requests set treated=1 where id=?', [$request_folder_id]);

        $data = array('done'=>'Success');

        return response()->json($data); //redirect()->back();
    }

}


