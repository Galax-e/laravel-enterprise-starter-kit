<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\FolderNotification;
use DB;
use Auth;

class FolderNotificationController extends Controller
{
    /**
    * Fetch Folder notification
    *
    */

    public function fetch(Request $request){

        $user = Auth::user();
        //$notif_count = DB::select('select count(*) from folder_notifications where status=0');
        
        $notif_count = FolderNotification::where('receiver_id', '=', Auth::user()->id)
            ->where('status', '=', 0)
            ->orderBy('created_at', 'desc')
            ->count();
        
        $data = array('user'=>$user, 'notif_count' => $notif_count);
        return response()->json($data);
    }

    // user has seen notification, turn status to 1
    public function notificationseen(Request $request)
    {
        $receiver_id =  Auth::user()->id;
        
        $status = 0;
        $notifications = DB::select('select * from folder_notifications where receiver_id = ? and status = ?', [$receiver_id, $status]);

        foreach($notifications as $notification){
            $notif_id = ((array) $notification)["id"];

            DB::update('update folder_notifications set status = ? where id = ?', [1, $notif_id]);
        }

        return response()->json((array) $notifications); //redirect()->back();
    }

    public function seenFolder(Request $request){

        $folder_id = request('folder_id');

        DB::table('user_folders')
            ->where('user_id', $user_id)
            ->where('folder_id', $folder_id)
            ->update(['status' => 1]);

        //DB::update('update activities set activity_to=? where element_id=?', ['none@kdsg.gov.ng', $folder_id]);

        $data = array('done'=>'Success');

        return response()->json($data); //redirect()->back();
    }
}
