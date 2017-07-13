<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Flash;

/** base table*/
use Auth;
use App\File;
use App\Memo;
use App\Comment;
use App\Folder;
use App\Activity;
use App\User;
use App\folder_request;
use App\pin;
use App\FolderNotification;
use App\RequestFileNotification;
use Illuminate\Support\Facades\Input;

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
   
   public function edit(Request $request,$id) {
		$folder_to = $request->input('folder_to');
		DB::update('update folders set folder_to = ? where id = ?',[$folder_to,$id]);

		$user2 = new Activity;
		$user2->activity_by= Input::get('comment_by');
		$user2->folder_id= Input::get('folder_id');
		$forward_activity= Input::get('forward_activity');
		$user2->activity = $forward_activity.$folder_to;
		$user2->save();
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
		$folder->fold_name= Input::get('fold_name');
		$folder->fold_desc= Input::get('fold_desc');
		$folder->folder_by= Input::get('folder_by');
		$folder->clearance_level= Input::get('clearance_level');
		$folder->save();
		$id = Auth::user()->email;
		$users = DB::select('select * from folders where folder_by = ?',[$id]);
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
		$activity->activity_by= Input::get('comment_by');
		$activity->folder_id= Input::get('folder_id');
		$activity->activity= Input::get('activity');
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
		
		$activity = new Activity;
		$activity->activity_by = $comment->comment_by; // request('comment_by');
		$activity->folder_id   = $comment->folder_id; //request('folder_id');
		$activity->activity    = request('activity');
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
	
	public function update(Request $request, $id)
    {

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
		$receiver_email=  $receiver_user['email'];

		$folder_to = $receiver_email; // $temp;
        DB::update('update folders set folder_to = ? where fold_name = ?',[$folder_to, $fold_name]);
       
        
        // create activity for sharing the folder
        $activity = new Activity;
        $shareInput = $receiver_email;
        $activity->activity_by= Input::get('comment_by');
        $activity->folder_id= Input::get('fold_name');
		//$activity->fileinfo= Input::get('fileinfo');
        $activity->activity= Input::get('activity'). $shareInput;
        $activity->save();        // create a notification and save to database
      
        $sender_id = Auth::user()->id;
        $receiver_id =  $receiver_user['id']; // DB::table('users')->where('email', $receiver_email)->first()->id;
              
		$folder_id = 1;
		
        // create notification
        FolderNotification::create(['folder_id'=>$folder_id, 'sender_id'=>$sender_id, 'receiver_id'=>$receiver_id]);        
		
		//return 'session';
        Flash::success('File has been sent to '. $first_name . ', '. $last_name);
        return redirect()->back()->with('Dashboard up-to-date');
    }
	
	
	public function share(Request $request, $id)
    {
        
		$folder = Folder::find($request->input('fold_name'));
        $folder->folder_to = $request->input('share-input');
		//$folder->fold_name = $request->input();
        $folder->save();
		
		$user2 = new Activity;
		$shareInput = Input::get('share-input');
		$user2->activity_by= Input::get('comment_by');
		$user2->folder_id= Input::get('fold_name');
		$user2->activity= Input::get('activity'). $shareInput;
		$user2->save();

		// create a notification and save to database
		$sender_id = Auth::user()->id;
		$receiver_email = Input::get('share-input');
		$receiver_id = User::where('email', $receiver_email)->first()->id;
		$folder_id = 1; //Folder::find($request->input('fold_name'))->first()->id;
		// create notification
		FolderNotification::create(['folder_id'=>folder_id, 'sender_id'=>sender_id, 'receiver_id'=>receiver_id]);

		
		//return 'session';
		Flash::success('File has been sent to '. Input::get('share-input'));
		return redirect()->back()->with('comment saved');
    }
	
	public function requestform(){

		$user = new folder_request;
		$user->request_from= Auth::user()->email;
		$user->foldername= Input::get('foldername');
		$user->desc= Input::get('desc');
		$user->save();

		$sender_id = Auth::user()->id;
		$folder_request_id = DB::table('folders')->where('fold_name', 'like', '$user->foldername')->get();

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

		$folder_req = new folder_request;
		$folder_req->request_from= Auth::user()->email;
		$folder_req->foldername= request('foldername');
		$folder_req->desc= request('desc');
		$folder_req->save();

		$sender_id = Auth::user()->id;
		$folder_request_id = DB::table('folders')->where('fold_name', 'like', '$user->foldername')->get();

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
		//return redirect()->back()->with('Request Sent');

		$data = array('successmsg'=> 'Folder request Successfule', 'action'=> 'Registry Will treat your request duly');
		return response()->json($data);
	}


	public function storepinform(){
		if (Input::get('new_pin') == Input::get('confirmpin')){
			$user = new pin;
			$user->user= Input::get('user');
			$user->old_pin= Input::get('old_pin');
			$user->new_pin= Input::get('new_pin');
			$user->save();

			Flash::success('Please keep your PIN from third party');
			return redirect()->back()->with('PIN Changed');
		}
		else{
			Flash::Error('Password No match in pigin');
			return redirect()->back()->with('LOL');

		}
	}

}