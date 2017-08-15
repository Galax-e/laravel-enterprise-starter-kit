<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use App\Repositories\AuditRepository as Audit;

use App\Repositories\Criteria\Permission\PermissionsByNamesAscending;
use App\Repositories\Criteria\Role\RolesByNamesAscending;
use App\Repositories\Criteria\User\UsersByUsernamesAscending;
use App\Repositories\Criteria\User\UsersWhereFirstNameOrLastNameOrUsernameLike;
use App\Repositories\Criteria\User\UsersWithRoles;
use App\Repositories\PermissionRepository as Permission;
use App\Repositories\RoleRepository as Role;
use App\Repositories\UserRepository as User;
use Auth;
use Flash;
use Illuminate\Http\Request;
use Mail;
use Setting;


use App\Repositories\Criteria\User\UserWhereEmailEquals;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;


use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/** base table*/
use App\Memo;
use App\Activity;
use App\MemoNotification;
use App\UserMemo;


use Illuminate\Support\Facades\Input;

class MemoController extends Controller
{

    /**
     * @param Application $app
     * @param Audit $audit
     */
     public function __construct(Application $app, Audit $audit, User $user, Role $role, Permission $perm)
    {
        parent::__construct($app, $audit);
        $this->user  = $user;
        $this->role  = $role;
        $this->perm  = $perm;
        // Set default crumbtrail for controller.
        session(['crumbtrail.leaf' => 'users']);
    }

    public function compose()
    {  
        Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = "Users"; // trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = "Compose New Memo"; //trans('admin/users/general.page.index.description'); // 
        
        $user_id = Auth::user()->email;

        $users = DB::select('select * from users');
        return view('views.actions.mailbox.compose', compact('users', 'page_title', 'page_description'));
    }
    
    
    public function inbox()
    {  
        Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = "Users"; // trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = "Incomings"; //trans('admin/users/general.page.index.description'); // 
        
        $user_id = Auth::user()->email;
        $memos = DB::table('memos')->where('emailto', 'like', '%'.$user_id.'%')->orderBy('created_at', 'DESC')->paginate(14);  
        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
        
        // remove memo notification when user is in inbox.
        $receiver_id =  Auth::user()->id;        
        $status = 0;
        $notifications = DB::select('select * from memo_notifications where receiver_id = ? and status = ?', [$receiver_id, $status]);

        foreach($notifications as $notification){
            $notif_id = ((array) $notification)["id"];

            DB::update('update memo_notifications set status = ? where id = ?', [1, $notif_id]);
        }
        // end...
        
        return view('views.actions.mailbox.inbox', compact('users', 'page_title', 'page_description', 'memos'));
    }
    
    public function read_memo(Request $request, $id) {
        Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title =  "Users"; // trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = "New Memo"; // trans('admin/users/general.page.index.description'); // "List of users";
        
        $user_id = Auth::user()->email;
        $memos = DB::select('select * from memos where id = ?', [$id]);
        $attachments = DB::select('select * from attachments');
        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
        
        return view('views.actions.mailbox.read-mail', compact('users', 'page_title', 'page_description', 'memos', 'attachments'));
   }    

    public function dataphp(){

        $memos = DB::select('select emailfrom, subject, message from memos');

        $data = array();
        foreach( $memos as $memo => $fields ) {
            $data[] = $fields;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData"=>$data);

        return response()->json($results);
    }

    public function sent()
    {  
       Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

       $page_title = "Users"; // trans('admin/users/general.page.index.title'); // "Admin | Users";
       $page_description = "Outgoings"; //trans('admin/users/general.page.index.description'); // 
       
       $user_id = Auth::user()->email;
       $memos = DB::table('memos')->where('emailto', 'like', '%'.$user_id.'%')->orderBy('created_at', 'DESC')->paginate(14); 
       $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
       return view('views.actions.mailbox.sent', compact('users', 'page_title', 'page_description', 'memos'));
    }

    public function askForFileMemo(Request $request)
    {  
		
		$emailto = Input::get('emailto');
        $user = Auth::user();

		$memo = new Memo;
		$memo->email_name = $user->email.', '.$user->last_name;
		$memo->emailfrom  = $user->email;
		$memo->subject    = Input::get('subject');
		$memo->message    = Input::get('message');
		$memo->emailto    = $emailto;
		$memo->save();					
			
        $memo_id = $memo->id;
        $sender_id = Auth::user()->id;

        $receiver_user = DB::table('users')->where('email', $emailto)->first();        
        $receiver_id =  $receiver_user->id;

        // send memo to user_memo table
        $user_memo = new UserMemo;
        $user_memo->user_id = $receiver_id;
        $user_memo->memo_id = $memo_id;
        $user_memo->save();

        $activity = new Activity;
        $activity->activity_by = $user->email;
        $activity->activity_by_post = $user->position || 'Admin';
        $activity->activity  = 'Sends mail for file-return to: '.Input::get('email_name');
        $activity->activity_to = $receiver_user->email;
        $activity->comment= Input::get('subject');
        $activity->type = 'memo';
        $activity->memo= Input::get('message');
        $activity->save();
        
        // create notification
        MemoNotification::create(['memo_id'=>$memo_id, 'sender_id'=>$sender_id, 'receiver_id'=>$receiver_id]);
		
		// return to inbox with properties
		Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

                
		Flash::success('Return File memo sent');
		return redirect()->back()->with('Memo sent to current file holder');  //view('views.actions.mailbox.inbox', compact('users', 'page_title', 'page_description', 'memos'))->with('Memo Sent');
    }
}
