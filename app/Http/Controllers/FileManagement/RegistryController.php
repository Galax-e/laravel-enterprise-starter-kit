<?php

namespace App\Http\Controllers\FileManagement;

use App\Repositories\AuditRepository as Audit;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Flash;
use DB;

/** base table*/
use App\Folder;

class RegistryController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // $this->dir = base_path("public/docs/files/1");
    }

    public function viewAll(Request $request)
    {
        Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = "Shared File";
        $page_description = "List of live files";
      
        $user_id = Auth::user()->email;
        $user_position = Auth::user()->position;
        $user_id2 = Auth::user()->username;
        
        $act = '%Forward%';        
        //$folder = Folder::all();
        
        $folders = DB::table('folders')->whereNotNull('folder_to')
            ->orWhere(function($query){
                $query->whereNotIn('folder_to', ['','registry@kdsg.gov.ng', 'root@hallowgate.com', 'peter@hallowgate.com']);
            })->orderBy('created_at', 'DESC')->paginate(12);
        //->where('folder_to', '!=', 'registry@kdsg.gov.ng')
        
        return view('views.actions.activity.shared', compact('page_title', 'page_description', 'folders'));
    }
}



