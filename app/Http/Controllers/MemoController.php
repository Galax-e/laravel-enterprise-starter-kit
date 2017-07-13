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

        $page_title = trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = trans('admin/users/general.page.index.description'); // "List of users";
        
        $user_id = Auth::user()->email;

        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
        return view('views.compose', compact('users', 'page_title', 'page_description'));
    }
    
    
    public function inbox()
    {  
        Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = trans('admin/users/general.page.index.description'); // "List of users";
        
        $user_id = Auth::user()->email;
        $memos = DB::table('memos')->where('emailto', $user_id)->orderBy('created_at', 'DESC')->paginate(4);  
        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
        return view('inbox', compact('users', 'page_title', 'page_description', 'memos'));
    }
    
    public function read_memo($id) {
        Audit::log(Auth::user()->id, trans('admin/users/general.audit-log.category'), trans('admin/users/general.audit-log.msg-index'));

        $page_title = trans('admin/users/general.page.index.title'); // "Admin | Users";
        $page_description = trans('admin/users/general.page.index.description'); // "List of users";
        
        $user_id = Auth::user()->email;
        $memos = DB::select('select * from memos where id = ?',[$id]);
        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(10);
        return view('read-mail', compact('users', 'page_title', 'page_description', 'memos'));
   }

    public function store_memo()
    {  
        $user = new Memo;
        $user->email_name= Input::get('email_name');
        $user->emailfrom= Input::get('emailfrom');
        $user->emailto= Input::get('emailto');
        $user->subject= Input::get('subject');
        $user->message= Input::get('message');
        $user->save();
        return 'inbox';
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
}
