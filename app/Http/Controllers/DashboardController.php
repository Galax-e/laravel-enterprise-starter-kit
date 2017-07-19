<?php 
namespace App\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use App\Repositories\AuditRepository as Audit;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Libraries\Arr;
use App\Libraries\Str;
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
use App\File;
use App\Memo;
use App\Comment;
use App\Folder;
use App\Activity;
use App\Document;
use App\MemoNotification;

use Illuminate\Support\Facades\Input;


class DashboardController extends Controller
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

    public function index()
    {
        Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = "Users | Dashboard"; // trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = "Your Desk"; // trans('admin/users/general.page.index.description'); // "List of users";

        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
		$user_email = Auth::user()->email;

		$activity = '%Forward%';
		
		//$folder = Folder::all();	
		$activities = DB::select('select * from activities where activity like ? order by created_at desc limit 5', [$activity]);

		$folders = DB::select('select * from folders where folder_to = ?', [$user_email]);
		$files = DB::select('select * from documents');
		$comments = DB::select('select * from comments');
		
		// return the count of the number of people in the department
		$dept_size = DB::select('select * from users where department =?', [Auth::user()->department]);
		$dept_size = count($dept_size);

        return view('dashboard', compact('users', 'page_title', 'page_description', 'folders', 'files', 'comments', 'activities', 'dept_size'));
    }

	public function commentRefresh(){

		$data = array('activity'=>'My activity', 'comment'=>'My comment');
		return response()->json($data);
	}
	
	public function store_memo()
    {  
		
		Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = trans('admin/users/general.page.index.description'); // "List of users";
		
		$user_id = Auth::user()->email;

        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
		
		$emailto = Input::get('emailto');

		foreach($emailto as $key => $user_name){
			$memo = new memo;
			$memo->email_name = Input::get('email_name');
			$memo->emailfrom = Input::get('emailfrom');

			// Create memonotification for each user.
			$temp = preg_replace('/\s+/', '', $user_name);
			$fullname_array = explode(',', $temp);
			$first_name = $fullname_array[0];
			$last_name  = $fullname_array[1];

			$receiver_object = DB::select('select * from users where first_name=? and last_name=?', [$first_name, $last_name]);		
			$temp_arr = array();
			foreach($receiver_object as $key => $value){
				foreach($value as $field => $data){
					$temp_arr[$field] = $data;
				}
			}
			$receiver_user = $temp_arr;  // receiver user. It's now easy to get the fields
			
			$receiver_email=  $receiver_user['email'];

			$memo->emailto = $receiver_email;
			$memo->subject = Input::get('subject');
			$memo->message = Input::get('message');
			$memo->save();


			$memo_id = 1;
			$sender_id = Auth::user()->id;
			$receiver_id =  $receiver_user['id'];
			
			// create notification
			MemoNotification::create(['memo_id'=>$memo_id, 'sender_id'=>$sender_id, 'receiver_id'=>$receiver_id]);
		}

		Flash::success('Email sent');
		return redirect()->back()->with('Memo Sent');
    }


	public function viewall()
    {
        Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = trans('admin/users/general.page.index.description'); // "List of users";

        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
		$user_id = Auth::user()->email;
		$user_id2 = 'root';
		
		$act = '%Forward%';
		
		//$folder = Folder::all();	
		$folderactivity = DB::table('activities')->where('activity', 'like', $act)->orderBy('created_at', 'DESC')->paginate(5);

		//$folder = Folder::all();	
		$activity = DB::table('activities')->where('activity_by', $user_id)->orderBy('created_at', 'DESC')->paginate(12);
        return view('views.actions.activity.viewall', compact('users', 'page_title', 'page_description', 'activity', 'folderactivity'));
    }

	public function viewallrequest()
    {
        Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = trans('admin/users/general.page.index.description'); // "List of users";

        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
		$user_id = Auth::user()->email;
		$user_id2 = 'root';
		
		$act = '%Forward%';
		
		//$folder = Folder::all();	
		$folderactivity = DB::table('activities')->where('activity', 'like', $act)->orderBy('created_at', 'DESC')->paginate(5);
		$folder_requests = DB::table('folder_requests')->orderBy('created_at', 'DESC')->paginate(20);
		$labels = array('label-warning', 'label-info');
		//$folder = Folder::all();	
		$activity = DB::table('activities')->where('activity_by', $user_id)->orderBy('created_at', 'DESC')->paginate(12);
        return view('views.actions.activity.viewallrequests', compact('users', 'page_title', 'page_description', 'activity', 'folderactivity','folder_requests','labels'));
    }

	
	
	public function store_session()
    {  
		
		Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = trans('admin/users/general.page.index.description'); // "List of users";
		
		$user_id = Auth::user()->email;

        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
		
		$user = new Folder;
		$user->fold_name= Input::get('fold_name');
		$user->fold_desc= Input::get('fold_desc');
		$user->folder_by= Input::get('folder_by');
		$user->clearance_level= Input::get('clearance_level');
		$user->save();
		$folders = DB::select('select * from folders where folder_by = ?',[$user_id]);
		return view('file', compact('users', 'page_title', 'page_description', 'folders'));
    }
	
	public function store(Request $request)
    {
        Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = trans('admin/users/general.page.index.description'); // "List of users";
		
		$user_id = Auth::user()->email;

        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
		
						
		$user = new File;
		$user->folder_id= Input::get('folder_id');
		$user->title= Input::get('name');
		$user->file_by= Input::get('file_by');
		if (Input::hasFile('image')){
			$file=Input::file('image');
			$file->move(public_path(). '/files', $file->getClientOriginalName());
			
			$user->name = $file->getClientOriginalName();
			$user->size = $file->getClientSize();
			$user->type = $file->getClientMimeType();
			
		$name = $file->getClientOriginalName();
		

		}
		$id= Input::get('folder_id');
		DB::table('folders')
            ->where('id', $id)
            ->update(array('latest_doc' => $name));
			
		
				
		$user->save();
		$folders = DB::select('select * from folders where folder_by = ?',[$user_id]);
		return view('file', compact('users', 'page_title', 'page_description', 'folders'));
	
	return 'data saved in database';
		/**file::create(Request::all());
		document::create(Request::all());
		return 'test';*/
    }	
}
