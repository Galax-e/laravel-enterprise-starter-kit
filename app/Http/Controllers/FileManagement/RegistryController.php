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
use App\Models\AppModels\Folder;

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

    public function viewFolderTransactions(Request $request)
    {
        Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = "Shared Files";
        $page_description = "List of live files";
            
        $act = '%Forward%';        
        
        $folders = DB::table('folders')->whereNotNull('folder_to')
            ->orWhere(function($query){
                $query->whereNotIn('folder_to', ['','registry@kdsg.gov.ng', 'root@hallowgate.com', 'peter@hallowgate.com']);
            })->orderBy('created_at', 'DESC')->paginate(12);
        
        return view('views.actions.activity.shared', compact('page_title', 'page_description', 'folders'));
    }

    public function searchFolderTransactions(Request $request){
        
        $page_title = "Shared Files";
        $page_description = "List of live files";
                
        $searchTerm = $request->input('searchterm'); 
        $searchTerm = "%$searchTerm%";
        
        $folders = DB::table('folders')->where('folder_to', 'like', $searchTerm)
            ->orderBy('created_at', 'DESC')->paginate(12); 

        return view('views.actions.activity.shared', compact('page_title', 'page_description', 'folders'));
    }    
}