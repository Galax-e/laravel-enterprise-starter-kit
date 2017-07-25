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
use App\folder_request;

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
    
    public function viewallcontacts()
    {
        $page_title = "Users | All Contact"; // trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = "All contact based on Department"; // trans('admin/users/general.page.index.description'); // "List of users";
        $user_id = Auth::user()->email;
		$users = DB::select('select * from users'); 
		return view('user.allcontact', compact('users', 'page_title', 'page_description'));
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

			$user = new Activity;
	        $user->activity_by = Input::get('emailfrom');
	        $user->activity_by_post = Auth::user()->position;
	        $user->activity = 'Sends mail to: '.Input::get('email_name');
	        $user->activity_to= $receiver_email;
	        $user->comment= Input::get('subject');
	        $user->memo= Input::get('message');
	        $user->save();
			
			// create notification
			MemoNotification::create(['memo_id'=>$memo_id, 'sender_id'=>$sender_id, 'receiver_id'=>$receiver_id]);
		}

		Flash::success('Email sent');
		return redirect()->back()->with('Memo Sent');
    }


	public function insert()
    {
        $id = request('id');
        $handleremail = request('handleremail');
        $treated = 1;
        DB::update('update folder_requests set treated = ?, request_handler = ? where id = ?', [$treated, $handleremail, $id]);

        return 'true';

    }

    public function viewall()
    {
        Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = trans('admin/users/general.page.index.description'); // "List of users";

        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
		$user_id = Auth::user()->email;
		$user_position = Auth::user()->position;
		$user_id2 = 'root';
		
		$act = '%Forward%';
		
		//$folder = Folder::all();	
		$folderactivity = DB::table('activities')->where('activity', 'like', $act)->orderBy('created_at', 'DESC')->paginate(5);

		//$folder = Folder::all();	
		$activity = DB::table('activities')->where('activity_by', $user_id)->orwhere('activity_by_post', $user_position)->orderBy('created_at', 'DESC')->paginate(12);
        return view('views.actions.activity.viewall', compact('users', 'page_title', 'page_description', 'activity', 'folderactivity'));
    }

    public function searchactivity()
    {
        Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = trans('admin/users/general.page.index.description'); // "List of users";

        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
		$user_id = Auth::user()->email;
		$user_id2 = 'root';		
		$act = '%Forward%';
		$search = Input::get('search');
		
		$search = '%'.$search.'%';
		
		//$folder = Folder::all();	
		$folderactivity = DB::table('activities')->where('activity', 'like', $act)->orderBy('created_at', 'DESC')->paginate(5);

		//$folder = Folder::all();	
		$activity = DB::table('activities')->where('activity_by', $user_id)->where('activity', 'like', $search)->orderBy('created_at', 'DESC')->paginate(12);
        return view('actions.activity.viewall', compact('users', 'page_title', 'page_description', 'activity', 'folderactivity'));
    }

	public function searchcontact()
    {
         $page_title = "Users | All Contact"; // trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = "All contact based on Department"; // trans('admin/users/general.page.index.description'); // "List of users";
        $user_id = Auth::user()->email;
		$users = DB::select('select * from users'); 
		$search = Input::get('search'); 
		$search = '%'.$search.'%';
		$users = DB::table('users')->where('first_name', 'like', $search)->orderBy('created_at', 'DESC')->paginate(12);

        return view('user.allcontact', compact('users', 'page_title', 'page_description'));
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
		$request_count = folder_request::all()->count();
		$completedrequest_count = folder_request::where('treated', '=', 1)->count();
		$activity = DB::table('activities')->where('activity_by', $user_id)->orderBy('created_at', 'DESC')->paginate(12);
        return view('actions.activity.viewallrequest', compact('users', 'page_title', 'page_description', 'activity', 'folderactivity','folder_requests','labels', 'request_count', 'completedrequest_count'));
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

    public function attachment(){
    	//include_once("db_connect.php");
		$uploaded_images = array();
		foreach($_FILES['upload_images']['name'] as $key=>$val){        
		    $upload_dir = "attachment_file/";
		    $upload_file = $upload_dir.$_FILES['upload_images']['name'][$key];
			$filename = $_FILES['upload_images']['name'][$key];
		    if(move_uploaded_file($_FILES['upload_images']['tmp_name'][$key],$upload_file)){
		        $uploaded_images[] = $upload_file;

				// db params
				$attach = new Document;
				$attach->name = $filename;
				$attach->file_by = Auth::user()->email;
				$attach->folder_id = Input::get('folder_id');

				$uploaded_images[] = $upload_file;// [$upload_file, $filename];

				$attach->save();

		    }
		}
		//return response()->json($uploaded_images);
		Flash::success('New file attached flash');
		return redirect()->back()->with('New file attached');
    }

        public function single_upload(){
        session_start();
        $session_id='1'; 
        $path = "uploads/";
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "pdf");

           $name = $_FILES['photo']['name'];
           $size = $_FILES['photo']['size'];
           if(strlen($name)) {
              list($txt, $ext) = explode(".", $name);
              if(in_array($ext,$valid_formats)) {
                 if($size<(10024*10024)) {

                    $image_name = time().$session_id.".".$ext;
                    $tmp = $_FILES['photo']['tmp_name'];
                    if(move_uploaded_file($tmp, $path.$image_name)){
					$attach = new Document;
					$attach->name = $image_name;
					$attach->file_by = Auth::user()->email;
					$attach->folder_id = Input::get('folder_id');
					$attach->save();

					$activity = new Activity;
					$activity->activity_by= Auth::user()->email;
					$activity->activity_by_post = Auth::user()->position;
					$activity->folder_id= Input::get('folder_id');
					$activity->fileinfo= $image_name;
					$activity->activity= ' Added new Document';
					$activity->save();
                    
					if($ext !== "pdf"){
                    	echo'
                    	<ul class="mailbox-attachments clearfix">
                    	<li>
		                  <span class="mailbox-attachment-icon has-img"><img src="uploads/'.$image_name.'" style="width: 100%; height: 100%" alt="Attachment"></span>
		                  <div class="mailbox-attachment-info">
		                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> '.$image_name.'</a>
		                        <span class="mailbox-attachment-size">
		                          1.9 MB
		                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
		                        </span>
		                  </div>
		                </li></ul>';
                   } else
                   echo'<ul class="mailbox-attachments clearfix">
                
                    	<li><span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
			                  <div class="mailbox-attachment-info">
			                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> '.$image_name.'</a>
			                        <span class="mailbox-attachment-size">
			                          1,245 KB
			                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
			                        </span>
			                  </div>
			           </li></ul>';
                    }
                    else
                    echo "Image Upload failed";
                 }
                 else
                 echo "Image file size max 1 MB";
              }
              else
              echo "Invalid file format..";
           }
           else
           echo "Please select image..!";
           exit;      
    }
}
