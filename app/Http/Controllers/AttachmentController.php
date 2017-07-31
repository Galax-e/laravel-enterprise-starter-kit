<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Attachment;
use App\Activity;
use Auth;
use DB;


class AttachmentController extends Controller
{
    public function memoAttachment(Request $request){
		

        session_start();
		$session_id='1'; 
		$path = 'attachment_file/';
		$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "pdf");
		
		$name = request('photo');
		//$size = request('s');
		
		$data = array('name'=> $name);

		return response()->json($data);
				

	}
}
