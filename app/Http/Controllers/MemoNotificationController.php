<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AppModels\MemoNotification;
use App\Models\AppModels\UserMemo;
use DB;
use Auth;

class MemoNotificationController extends Controller
{

    /**
    * Fetch Memo notification
    *
    */
    public function fetch(Request $request){

        $user = Auth::user();
                
        $memo_count = MemoNotification::where('receiver_id', Auth::user()->id)
            ->where('status', 0)
            ->orderBy('created_at', 'desc')
            ->count();
        
        $data = array('user'=>$user, 'memo_count' => $memo_count);
        return response()->json($data);
    }

    // user has seen notification, turn status to 1
    public function notificationseen(Request $request)
    {
        $user = Auth::user();
        $receiver_id =  $user->id;
        
        $status = 0;
        $notifications = MemoNotification::where('receiver_id', $receiver_id)->where('status', 0)->get();
        //DB::select('select * from memo_notifications where receiver_id = ? and status = ?', [$receiver_id, $status]);

        foreach($notifications as $notification){
            $notif_id = $notification->id;
            //((array) $notification)["id"];

            DB::update('update memo_notifications set status = ? where id = ?', [1, $notif_id]);
        }

        return response()->json((array) $notifications); //redirect()->back();
    }

    // when user sees the memo, that memo should leave the header
    public function seenMemo(Request $request)
    {
        
        $memo_id = request('memo_id');
        $user = Auth::user();

        //DB::update('update memos set treated=1 where id=?', [$memo_id]);
        DB::table('user_memos')
            ->where('user_id', $memo_id)
            ->where('memo_id', $user->id)
            ->update(['status' => 1]);

        $update = UserMemo::where('user_id', $user->id)->where('memo_id', $memo_id)->first();
        if($update->status == 0){
            $update->status = 1;
            $update->save();
        }

        echo $update->status;

        //$data = array('done'=>'Success');

        //return response()->json($data); //redirect()->back();
    }

}
