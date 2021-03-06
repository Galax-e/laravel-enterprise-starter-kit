<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use View;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Flash;
use Response;

/** base table*/
use Auth;
use App\Models\AppModels\File;
use App\Models\AppModels\Memo;
use App\Models\AppModels\Comment;
use App\Models\AppModels\Folder;
use App\Models\AppModels\Activity;
use App\Models\AppModels\User;
use App\Models\AppModels\FolderRequest;
use App\Models\AppModels\folder_request;
use App\Models\AppModels\Pin;
use App\Models\AppModels\FolderNotification;
use App\Models\AppModels\RequestFileNotification;
use Illuminate\Support\Facades\Input;
use App\Models\AppModels\UserFolder;
use Carbon\Carbon;

class FilesController extends Controller {
   
   public function index(){
	  $id = 'Ayo';
      $users = DB::select('select * from files where file_by = ?',[$id]);
      return view('stud_edit_view',['users'=>$users]);
   }
   public function show($id) {
      $users = DB::select('select * from files where id = ?',[$id]);
      return view('stud_update',['users'=>$users]);
   }
   
    public function show_message($id) {
      $user=Memo::findorfail($id);
      return view('read', compact('user'));
   }
   
   public function edit(Request $request, $id) {
		$folder_to = $request->input('folder_to');
		DB::update('update folders set folder_to = ? where id = ?',[$folder_to,$id]);

		$activity = new Activity;
		$activity->activity_by= Input::get('comment_by');
		$activity->activity_by_post = Auth::user()->position;
		$activity->folder_id= Input::get('folder_id');
		$forward_activity = Input::get('forward_activity');
		$activity->activity = $forward_activity.$folder_to;
		$activity->save();
		echo "Record updated successfully.<br/>";
		echo '<a href = "/edit-records">Click Here</a> to continue.';
   }
   
   public function upload()
    {
        /**$user=file::all();
		return view("file", compact('user'));*/
		return view("file");
    }
	
	public function session()
    {  
		return view('session');
    }
	
	public function read()
    {  
		return view('read');
    }
	
	public function inbox()
    {  
		$id = 'Ayo';	
		$message = DB::select('select * from messages');
        return view('inbox', compact('message'));
    }
	
	public function compose()
    {  
		return view('compose');
    }
	
	public function store_session()
    {  
		$folder = new Folder;
		$folder->name= Input::get('fold_name');
		$folder->desc= Input::get('fold_desc');
		$folder->folder_by= Input::get('folder_by');
		$folder->clearance_level= Input::get('clearance_level');
		$folder->save();

		$email = Auth::user()->email;
		$users = DB::select('select * from folders where folder_by = ?',[$email]);
		return view('file',['users'=>$users]);
    }
	
	public function store_message()
    {  
		$message = new Message;
		$message->emailto= Input::get('emailto');
		$message->subject= Input::get('subject');
		$message->message= Input::get('message');
		$message->save();
		return view('session');
    }
	
	
	
	public function comment()
    {  
		$comment = new Comment;
		$comment->folder_id= Input::get('folder_id');
		$comment->comment_by= Input::get('comment_by');	
		$comment->comment= Input::get('comment');
		$comment->save();
		
		$activity = new Activity;
		$activity->activity_by = Input::get('comment_by');
		$activity->activity_by_post = Auth::user()->position;
		$activity->folder_id= Input::get('folder_id');
		$activity->activity = Input::get('activity');
		$activity->comment= Input::get('comment');
		$activity->save();
		
		//return 'session';
		Flash::success('Your comment has been added to the File successfully');

		$data = array('activity'=>$activity, 'comment'=>$comment);
		return response()->json($data);
		//return redirect()->back()->with($data); //json_encode($data);// 

		// Add audit to most of the methods defined here.
    }

	public function ajaxComment(){
		
		// fetch the values from the comment form.
		$comment = new Comment;
		$comment->folder_id  = request('folder_id');
		$comment->comment_by = request('comment_by');	
		$comment->comment    = request('comment');
		$comment->save();


		// update comment on folder to enable searching...
		$folder_id = request('folder_id');
		$concat_comment = $comment->comment;
		$concat = DB::select('select * from folders where id=?', [$folder_id]);
        foreach($concat as $com){
            $concat_comment .= ((array) $com)["last_comment"];
        }
		DB::update('update folders set last_comment=? where id=?', [$concat_comment, $folder_id]);
		
		$activity = new Activity;
		$activity->activity_by = $comment->comment_by; // request('comment_by');
		$activity->folder_id   = $comment->folder_id; //request('folder_id');
		$activity->element_id  = $folder_id;
		$activity->activity    = Auth::user()->full_name. ' commented on '. request('activity');
		$activity->comment     = $comment->comment ; //request('comment');
		$activity->save();

		//$comments = DB::select('select * from comments');
		$data = array('comments'=>$comment->comment);

		//return 'session';
		// Flash::success('Your comment has been added to the File successfully');
		return response()->json($data);
		//return redirect()->back()->with($data); //json_encode($data);//
	}
	
    public function store(Request $request)
    {
        $user = new File;
		
		$user->folder_id= Input::get('folder_id');
		$user->title= Input::get('name');
		if (Input::hasFile('image')){
			$file=Input::file('image');
			$file->move(public_path(). '/files', $file->getClientOriginalName());
			
			$user->name = $file->getClientOriginalName();
			$user->size = $file->getClientSize();
			$user->type = $file->getClientMimeType();

		}
	
		$user->save();
		
		return 'data saved in database';
			/**file::create(Request::all());
			document::create(Request::all());
			return 'test';*/
    }
	
	public function forward(Request $request)
    {
		$user = Auth::user();
		// retrieve the folder handle and save.
       	$fold_name = Input::get('fold_name');
       	$temp = Input::get('share-input');
        // remove white spaces...
        $temp = preg_replace('/\s+/', '', $temp);
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
		$receiver_email =  $receiver_user['email'];

		
		$folder_to = $receiver_email; // $temp;
		try{
        	DB::update('update folders set folder_to = ?, forwarded_by=? where name = ?', [$folder_to, $user->email, $fold_name]);
		}catch(\Exception $e){
			echo ("Error forwarding");
		}

	    $folder = DB::select('select id from folders where name = ?', [$fold_name]);
		$folder_id = 0;
		foreach($folder as $fid){
			$folder_id = ((array) $fid)["id"];
		}

		// update the folder to reflect the current user
		$userFolder = new UserFolder;
		$userFolder->user_id = $receiver_user['id'];
		$userFolder->passer_id = $user->id;
		$userFolder->folder_id = $folder_id;
		$userFolder->save();

		DB::update('update folders set forwarded_at = ? where name=?', [Carbon::now(), $fold_name]);
     
        $sender_id = $user->id;
        $receiver_id =  $receiver_user['id']; // DB::table('users')->where('email', $receiver_email)->first()->id;
		
        // create notification
        FolderNotification::create(['folder_id'=>$folder_id, 'sender_id'=>$sender_id, 'receiver_id'=>$receiver_id]);        
		
		// create activity for sharing the folder
        $activity   = new Activity;
        $shareInput = $receiver_user['first_name'].', '.$receiver_user['last_name'];
        $activity->activity_by = $user->email;
		$activity->activity_to = $receiver_email;
        $activity->folder_id   = Input::get('fold_name');
		$activity->element_id  = $folder_id;
		$activity->fileinfo    = Input::get('fileinfo');
        $activity->activity    = $user->full_name.' Forwarded this folder: '.$fold_name.' to '. $shareInput;
        $activity->save();  	

		//return 'session';
        Flash::success('File has been forwarded to '. $first_name . ', '. $last_name);
        //return redirect()->back()->with('Dashboard up-to-date');

		return Response::json(array('message' => 'Success'));
    }
	
	public function share(Request $request)
    {
		$user = Auth::user();
		$folder_no = Input::get('folder_no');
		
		$temp = Input::get('share-input');
        // remove white spaces...
        $temp = preg_replace('/\s+/', '', $temp);
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
		$folder_to = $receiver_user['email'];


		$shared_by = $user->email;
		DB::update('update folders set folder_to = ?, shared_by = ?, forwarded_at = ? where folder_no = ?', [$folder_to, $shared_by, Carbon::now(), $folder_no]);
		
		// get folder id
		$folder = DB::select('select id from folders where folder_no = ?', [$folder_no]);
		
		$folder_id = 0;
		foreach($folder as $fid){
			$folder_id = ((array) $fid)["id"];
		}

		// update the folder to reflect the current user
		$userFolder = new UserFolder;
		$userFolder->user_id = $receiver_user['id'];
		$userFolder->passer_id = $user->id;
		$userFolder->folder_id = $folder_id;
		$userFolder->save();

		// create a notification and save to database
		$sender_id = $user->id;
		$receiver_email = $folder_to;// Input::get('share-input');
		$receiver_id = User::where('email', $receiver_email)->first()->id;
		//$folder_id = 1; //Folder::find($request->input('fold_name'))->first()->id;
		// create notification
		FolderNotification::create(['folder_id'=>$folder_id, 'sender_id'=>$sender_id, 'receiver_id'=>$receiver_id]);

		$activity = new Activity;
		$shareInput = $receiver_email; // Input::get('share-input');
		$activity->activity_by = $user->email;
		$activity->folder_id   = $folder_no; // Input::get('folder_no');
		$activity->element_id  = $folder_id;
		$activity->fileinfo    = Input::get('folder_no');
		$activity->activity_to = $folder_to; //Input::get('share-input');
		$activity->activity_by_post = $user->position;
		$activity->activity    = 'Registry shared/forwarded this folder to '. $shareInput;
		$activity->save();
		
		//return 'session';
		Flash::success('File has been shared with '. Input::get('share-input'));
		return redirect()->back()->with('comment saved');
    }

	public function shareClearanceLevel(Request $request){
		
		$folder_no = request('item_name');
		$folder = DB::table('folders')->where('folder_no', $folder_no)->first();
		
		$folder_clearance = $folder->clearance_level;
		$not_to_share = [Auth::user()->email, 'registry@kdsg.gov.ng', 'peter@hallowgate.com', 'root@hallowgate.com']; 
		$users = DB::table('users')->where('clearance_level', '>=', $folder_clearance)
		->whereNotIn('email', $not_to_share)->get();
		
		$data = array('users'=>$users);

		$not_in = $not_to_share;// array("root@hallowgate.com", "peter@hallowgate.com", "registry@kdsg.gov.ng");


		$folder2 = DB::table('folders')->whereNotNull('folder_to')
			->where('folder_no', $folder_no)
			->orWhere(function($query){
				$query->whereNotIn('folder_to', ['', 'registry@kdsg.gov.ng', 'peter@hallowgate.com', 'root@hallowgate.com']);
			})->first();

		if($folder2){

			//if (!in_array($folder->folder_to, $not_in)) {
				$user_name = DB::table('users')->where('email', $folder2->folder_to)->first();
				$user_name = $user_name->first_name.', '.$user_name->last_name;
				$data['current_holder'] = $user_name;
				$user_is_admin = Auth::user()->isRoot();
				$data['user_is_admin'] = $user_is_admin;
				$data['folder'] = $folder2;
			//}	
			//else{
				//$data['current_holder'] = 'Nobody';
			//}
		}
		else{
			$data['current_holder'] = 'Nobody';
		}
		//$user_name = DB::table('users')->where('email', $folder->folder_to)->first(); 	
		return response()->json($data);
	}
	
	public function requestform(){

		$user = new Folder_request;
		$user->request_from= Auth::user()->email;
		$user->foldername= Input::get('foldername');
		$user->desc= Input::get('desc');
		$user->save();

		$sender_id = Auth::user()->id;
		$folder_request_id = DB::table('folders')->where('name', 'like', '$user->foldername')->get();

		if (!$folder_request_id){
			$folder_request_id = 1;
		}
		else{

			$temp_arr = array();

			foreach($folder_request_id as $key => $value){
				foreach($value as $field => $data){
					$temp_arr[$field] = $data;
				}
			}
			$folder_request_id = $temp_arr['id']; // count(folder_request_id);
		}

		RequestFileNotification::create(['folder_request_id'=>$folder_request_id, 'sender_id'=>$sender_id, 'receiver_roles'=> 2]);  

		Flash::success('Your Request for File has been sent to Registry');
		return redirect()->back()->with('Request Sent');
	}

	public function ajaxFolderRequest()
	{

		$folder_req = new FolderRequest;
		$folder_req->from= Auth::user()->email;
		$folder_req->folder_name= request('name');
		$folder_req->folder_desc= request('desc');
		
		$sender_id = Auth::user()->id;
		$folder_request_id = DB::table('folders')->where('name', 'like', '$folder_req->folder_name')->get();

		if (!$folder_request_id){
			$folder_request_id = 1;
		}
		else{
			$temp_arr = array();
			foreach($folder_request_id as $key => $value){
				foreach($value as $field => $data){
					$temp_arr[$field] = $data;
				}
			}
			$folder_request_id = $temp_arr['id']; // count(folder_request_id);
		}

		$folder_req->folder_id = $folder_request_id;
		$folder_req->save();

			$user = new Activity;
	        $user->activity_by = Auth::user()->email;
	        $user->activity_by_post = Auth::user()->position;
	        $user->activity = 'Requested for file';
	        $user->fileinfo = request('name').' | '.request('desc');
	        $user->save();

		RequestFileNotification::create(['folder_request_id'=>$folder_request_id, 'sender_id'=>$sender_id, 'receiver_roles'=> 2]);  

		Flash::success('Your Request for File has been sent to Registry');
		//return redirect()->back()->with('Request Sent');

		$data = array('successmsg'=> 'Folder request Successful', 'action'=> 'Registry Will treat your request duly');
		return response()->json($data);
	}


	public function storepinform(){
		
		$user = Auth::user();
		$currentPin = $user->pin;

		$currentPinCheck = Input::get('current_pin');
		
		if($currentPin !== strval($currentPinCheck)){

			Flash::warning('PIN does not match');
			return redirect()->back()->with('Enter correct existing PIN');
		}


		$pin = Input::get('new_pin');
		$id = Auth::user()->id;
		if (Input::get('new_pin') == Input::get('confirmpin')){
			DB::update('update users set pin = ? where id = ?',[$pin,$id]);

			$user = new Activity;
	        $user->activity_by = Auth::user()->email;
	        $user->activity_by_post = Auth::user()->position;
	        $user->activity = 'Change PIN';
	        $user->save();

			Flash::success('Please keep your PIN from third party');
			return redirect()->back()->with('PIN Changed');
		}
		else{
			Flash::error('PIN does not match');
			return redirect()->back()->with('LOL');
		}
	}

	public function authenticatePin(){
		// fetch the values from the comment form.

		$user = Auth::user();
		$currentPin = $user->pin;

		$postPinToAuth = request('post_pin_input');

		if($postPinToAuth){

			if($currentPin == strval($postPinToAuth)){
				return "true";
			}else{
				Flash::error('Wrong Pin');
				return "false";
			}
		}
		
		$forwardPinToAuth = request('forward_pin_input');

		if($forwardPinToAuth){
			
			if($currentPin == strval($forwardPinToAuth)){
				return "true";
			}else{
				Flash::error('Wrong Pin');				
				return "false";
			}
		}

		return "false";
		
	}

}