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
use App\Attachment;

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
		
		$forward_to_users = DB::select('select * from users');

		$dept_users = DB::select('select * from users');
		$user_email = Auth::user()->email;

		$activity = '%Forward%';
		
		//$folder = Folder::all();	
		$activities = DB::select('select * from activities where activity like ?  order by created_at desc limit 5', [$activity]);	
		$file_movement = DB::select('select * from activities');

		$folders = DB::select('select * from folders where folder_to = ? order by created_at desc', [$user_email]);
		$files = DB::select('select * from documents order by created_at desc');
		$comments = DB::select('select * from comments');
		
		// return the count of the number of people in the department
		$dept_size = DB::select('select * from users where department =?', [Auth::user()->department]);
		$dept_size = count($dept_size);

        return view('dashboard', compact('users', 'forward_to_users', 'dept_users', 'page_title', 'page_description', 'folders', 'files', 'comments', 'activities', 'dept_size', 'file_movement'));
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

		$memo = new Memo;
		$memo->email_name = Input::get('email_name');
		$memo->emailfrom = Input::get('emailfrom');
		$memo->subject = Input::get('subject');
		$memo->message = Input::get('message');
		$memo->emailto = "";
		$memo->save();

		foreach($emailto as $key => $user_name){

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
			$memo->emailto .= $receiver_email.', ';
			
			

			// call attachment...
			$attachment_name = Input::get('attachment_name');
			//$attachment = DB::select('select * from attachments where name=?', [$attachment_name]);
			//DB::update("update attachments set memo_id=? where name=?", [$memo->id, $attachment_name]);
			

			$memo_id = $memo->id;
			$sender_id = Auth::user()->id;
			$receiver_id =  $receiver_user['id'];

			$activity = new Activity;
	        $activity->activity_by = Input::get('emailfrom');
	        $activity->activity_by_post = Auth::user()->position;
	        $activity->activity = 'Sends mail to: '.Input::get('email_name');
	        $activity->activity_to= $receiver_email;
	        $activity->comment= Input::get('subject');
			$activity->type = 'memo';
	        $activity->memo= Input::get('message');
	        $activity->save();
			
			// create notification
			MemoNotification::create(['memo_id'=>$memo_id, 'sender_id'=>$sender_id, 'receiver_id'=>$receiver_id]);
		}
		// db update $memo->save();
		DB::update("update memos set emailto=? where id=?", [$memo->emailto, $memo->id]);
		$attachment_id = Input::get('attachment_id');
		DB::update("update attachments set memo_id=? where id=?", [$memo->id, $attachment_id]);

		// return to inbox with properties
		Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = trans('admin/users/general.page.index.description'); // "List of users";
        
        $user_email = Auth::user()->email;
        $memos = DB::table('memos')->where('emailto', $user_email)->orderBy('created_at', 'DESC')->paginate(14);  
        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
        
		Flash::success('Email sent');
		return redirect()->route('inbox');  //view('views.actions.mailbox.inbox', compact('users', 'page_title', 'page_description', 'memos'))->with('Memo Sent');
    }


	public function insert()
    {
        $id = request('id');
        $handleremail = request('handleremail');
        $treated = 1;
        DB::update('update folder_requests set treated = ?, request_handler = ? where id = ?', [$treated, $handleremail, $id]);
		DB::update('update request_file_notifications set status = 1 where id = ?', [$id]);

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
		$user_id2 = Auth::user()->username;
		
		$act = '%Forward%';
		
		//$folder = Folder::all();	
		$folderactivity = DB::table('activities')->where('activity', 'like', $act)->orderBy('created_at', 'DESC')->paginate(5);

		//$folder = Folder::all();	
		$activity = DB::table('activities')->where('activity_by', $user_id)->orwhere('activity_by', $user_id2)->orwhere('activity_by_post', $user_position)->orderBy('created_at', 'DESC')->paginate(12);
        return view('views.actions.activity.viewall', compact('users', 'page_title', 'page_description', 'activity', 'folderactivity'));
    }

    public function searchactivity()
    {
        Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = trans('admin/users/general.page.index.description'); // "List of users";

        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
		$user_id = Auth::user()->email;
		$user_id2 = Auth::user()->username;	
		$act = '%Forward%';
		$search = Input::get('search');
		
		$search = '%'.$search.'%';
		
		//$folder = Folder::all();	
		$folderactivity = DB::table('activities')->where('activity', 'like', $act)->orderBy('created_at', 'DESC')->paginate(5);

		//$folder = Folder::all();	
		$activity = DB::table('activities')->whereIn('activity_by', [$user_id,$user_id2])->where('activity', 'like', $search)->orwhere('fileinfo', 'like', $search)->orderBy('created_at', 'DESC')->paginate(12);
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
		$path = Input::get('path');
		$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "pdf");

		$name = $_FILES['photo']['name'];
		$size = $_FILES['photo']['size'];
		if(strlen($name)) {
			list($txt, $ext) = explode(".", $name);
			if(in_array($ext,$valid_formats)) {

				$image_name = time().$session_id.".".$ext;
				$tmp = $_FILES['photo']['tmp_name'];
				if(move_uploaded_file($tmp, $path.$image_name)){
				$attach = new Document;
				$attach->name = $image_name;
				$attach->original_name = $name;
				$attach->file_by = Auth::user()->email;
				$attach->folder_id = Input::get('folder_id');
				$attach->save();

				DB::update('update folders set latest_doc=? where id=?', [$image_name, $attach->folder_id]);

				$activity = new Activity;
				$activity->activity_by= Auth::user()->email;
				$activity->activity_by_post = Auth::user()->position;
				$activity->folder_id= Input::get('folder_id');
				$activity->fileinfo= $name;
				$activity->activity= ' Added new Document';
				$activity->save();
				
				if($ext !== "pdf"){
					echo'
					<ul class="mailbox-attachments clearfix">
					<li>
						<span class="mailbox-attachment-icon has-img"><img src="'.$path.'/'.$image_name.'" style="width: 100%; height: 100%" alt="Attachment"></span>
						<div class="mailbox-attachment-info">
						<a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> '.$name.'</a>
							<span class="mailbox-attachment-size">
								'.$size.'
								<a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
							</span>
						</div>
					</li></ul>';
				} else
				echo'<ul class="mailbox-attachments clearfix">
			
					<li><span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
							<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> '.$name.'</a>
								<span class="mailbox-attachment-size">
									'.$size.'
									<a href="'.$path.'/'.$image_name.'" target="_blank" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
								</span>
							</div>
					</li></ul>';
				}
				else
				echo "File Upload fail";
			}
			else
			echo "Invalid file format..";
		}
		else
		echo "Please select image or pdf..!";
		exit;      
    }

	public function compose_single_upload(){
		session_start();
		$session_id='1'; 
		$path = 'attachment_file/';
		$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "pdf");

		$name = $_FILES['photo']['name'];
		$size = $_FILES['photo']['size'];
		if(strlen($name)) {
			list($txt, $ext) = explode(".", $name);
			if(in_array($ext,$valid_formats)) {

				$image_name = time().$session_id.".".$ext;
				$tmp = $_FILES['photo']['tmp_name'];
				if(move_uploaded_file($tmp, $path.$image_name)){
				
				$attach = new Attachment;
				$attach->name = $image_name;
				$attach->original_name = $name;
				$attach->memo_by = Auth::user()->email;
				$attach->save();

				//DB::update('update folders set latest_doc=? where id=?', [$image_name, $attach->folder_id]);

				$activity = new Activity;
				$activity->activity_by= Auth::user()->email;
				$activity->activity_by_post = Auth::user()->position;
				$activity->fileinfo= $name;
				$activity->activity= ' Added new Document';
				$activity->save();
				
				if($ext !== "pdf"){
					echo '<input type="hidden" name="attachment_id" value="'.$attach->id.'">';
					echo'
					<ul id="attach_image" class="mailbox-attachments clearfix attachdoc">
					<li>
						<span class="mailbox-attachment-icon"><i class="fa fa-file-image-o"></i></span>
						<div class="mailbox-attachment-info">
						<a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> '.$name.'</a>
							<span class="mailbox-attachment-size">
								'.$size.'								
							</span>
						</div>
					</li>
					</ul>';
				} else {
				echo '<input type="hidden" name="attachment_id" value="'.$attach->id.'">';
				echo'<ul id="attach_pdf" class="mailbox-attachments clearfix attachdoc">
			
					<li><span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
							<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> '.$name.'</a>
								<span class="mailbox-attachment-size">
									'.$size.'
								</span>
							</div>
					</li></ul>';
					}
				}
				else
				echo "File Upload failed";
			}
			else
			echo "Invalid file format..";
		}
		else
		echo "Please select image or pdf..!";
		exit; 
	}
}
