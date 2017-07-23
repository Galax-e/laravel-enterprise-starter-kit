<?php

 // $namespace = '\Unisharp\Laravelfilemanager\controllers';
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::get('dataphp', ['as' => 'dataphp', 'uses' => 'MemoController@dataphp']);

Route::get('show-message/{id}','FilesController@show_message');
Route::post('edit/{id}','FilesController@edit');
Route::get('edit-records','FilesController@index');


Route::get('/error',function(){
   abort(503);
});

Route::get('testnotif', 'MessageController@index');


// Authentication routes...
Route::get( 'auth/login',               ['as' => 'login',                   'uses' => 'Auth\AuthController@getLogin']);
Route::post('auth/login',               ['as' => 'loginPost',               'uses' => 'Auth\AuthController@postLogin']);
Route::get( 'auth/logout',              ['as' => 'logout',                  'uses' => 'Auth\AuthController@getLogout']);
// Registration routes...
Route::get( 'auth/register',            ['as' => 'register',                'uses' => 'Auth\AuthController@getRegister']);
Route::post('auth/register',            ['as' => 'registerPost',            'uses' => 'Auth\AuthController@postRegister']);
// Verify email...
Route::get( 'auth/verify/{token}',      ['as' => 'confirm_email',           'uses' => 'Auth\AuthController@verify']);
Route::get( 'auth/verify',              ['as' => 'confirm_emailGet',        'uses' => 'Auth\AuthController@getVerify']);
Route::post('auth/verify',              ['as' => 'confirm_emailPost',       'uses' => 'Auth\AuthController@postVerify']);
// Password reset link request routes...
Route::get( 'password/email',           ['as' => 'recover_password',        'uses' => 'Auth\PasswordController@getEmail']);
Route::post('password/email',           ['as' => 'recover_passwordPost',    'uses' => 'Auth\PasswordController@postEmail']);
// Password reset routes...
Route::get( 'password/reset/{token}',   ['as' => 'reset_password',          'uses' => 'Auth\PasswordController@getReset']);
Route::post('password/reset',           ['as' => 'reset_passwordPost',      'uses' => 'Auth\PasswordController@postReset']);

// Registration terms
Route::get( 'faust',                    ['as' => 'faust',                   'uses' => 'FaustController@index']);

// Application routes...
Route::get( '/',          ['as' => 'backslash',   'uses' => 'HomeController@index']);
Route::get( 'home',       ['as' => 'home',        'uses' => 'HomeController@index']);
Route::get( 'welcome',    ['as' => 'welcome',     'uses' => 'HomeController@welcome']);

// Routes in this group must be authorized.
Route::group(['middleware' => 'authorize'], function () {
    // Application routes...
    Route::get(   'compose',        ['as' => 'compose',          'uses' => 'MemoController@compose']);
	Route::get(   'dashboard',      ['as' => 'dashboard',          'uses' => 'DashboardController@index']);
	Route::get(   'inbox',          ['as' => 'inbox',          'uses' => 'MemoController@inbox']);
    Route::get(   'read_memo/{id}', ['as' => 'read_memo/{id}',          'uses' => 'MemoController@read_memo']);
	Route::get(   'session',        ['as' => 'session',          'uses' => 'DashboardController@session']);
    Route::post(   'searchactivity',      ['as' => 'searchactivity',          'uses' => 'DashboardController@searchactivity']);
    Route::post(   'searchcontact',      ['as' => 'searchcontact',          'uses' => 'DashboardController@searchcontact']);
	Route::post(  'store',          ['as' => 'store',          'uses' => 'DashboardController@store']);
    Route::get(   'viewall',        ['as' => 'viewall',          'uses' => 'DashboardController@viewall']);
    Route::get(   'viewallcontacts',        ['as' => 'viewallcontacts',          'uses' => 'DashboardController@viewallcontacts']);
    Route::get(   'viewallrequest', ['as' => 'viewallrequest',          'uses' => 'DashboardController@viewallrequest']);
	Route::post(  'store-session',  ['as' => 'store-session',          'uses' => 'DashboardController@store_session']);
	Route::post(  'store_memo',     ['as' => 'store_memo',          'uses' => 'DashboardController@store_memo']);
    Route::post(  'insert',     ['as' => 'insert',          'uses' => 'DashboardController@insert']);
    Route::post(  'attachment',     ['as' => 'attachment',          'uses' => 'DashboardController@attachment']);
    Route::post(  'single_upload',     ['as' => 'single_upload',          'uses' => 'DashboardController@single_upload']);
    Route::get(   'user/profile',   ['as' => 'user.profile',       'uses' => 'UsersController@profile']);
    Route::patch( 'user/profile',   ['as' => 'user.profile.patch', 'uses' => 'UsersController@profileUpdate']);

    //Notifications
    Route::get( 'folder_notification',['as' => 'folder_notification',  'uses' => 'FolderNotificationController@fetch']);
    Route::get( 'memo_notification',  ['as' => 'memo_notification',    'uses' => 'MemoNotificationController@fetch']);
    Route::get( 'request_file_notification',  ['as' => 'request_file_notification',    'uses' => 'RequestFileNotificationController@fetch']);

    Route::get( 'notif_seen', ['as' => 'notif_seen',  'uses' => 'FolderNotificationController@notificationseen']);
    Route::get( 'memo_seen',  ['as' => 'memo_seen',   'uses' => 'MemoNotificationController@notificationseen']);
    Route::get( 'request_file_seen',  ['as' => 'request_file_seen',   'uses' => 'RequestFileNotificationController@notificationseen']);
    
    Route::get(   'user/profile/photo',   ['as' => 'user.profile.photo',       'uses' => 'UsersController@profilePhoto']);
    Route::patch( 'user/profile/photo',   ['as' => 'user.profile.photo.patch', 'uses' => 'UsersController@profilePhotoUpdate']);

    // other routers
    Route::get('read', 'FilesController@read');
    Route::post('comment', 'FilesController@comment');
    Route::get('commentrefresh', ['as' => 'commentrefresh', 'uses' => 'DashboardController@commentRefresh']);
    Route::get('ajaxcomment', ['as' => 'ajaxcomment', 'uses' => 'FilesController@ajaxComment']);

    Route::get('authpin', ['as' => 'authpin', 'uses' => 'FilesController@authenticatePin']);

    Route::post('requestform','FilesController@requestform');
    Route::post('ajaxfolderrequest', ['as'=>'ajaxfolderrequest', 'uses'=>'FilesController@ajaxFolderRequest']);
    Route::post('storepinform', ['as'=>'storepinform', 'uses'=>'FilesController@storepinform']);

    Route::post('forward',['as'=>'forward', 'uses'=>'FilesController@forward']); // remove the id
    Route::post('share','FilesController@share');

    // creating documents and uploading file
    Route::post('newdocument','FileManagement\UploadController@upload');
    Route::post('newfolder','FileManagement\UploadController@newfolder');

    Route::get( 'scandir',    ['as' => 'scandir',    'uses' => 'FileManagement\SearchFolderController@scanDirectory']);

    // Site administration section
    Route::group(['prefix' => 'admin'], function () {
        // User routes
        Route::post(  'users/enableSelected',          ['as' => 'admin.users.enable-selected',  'uses' => 'UsersController@enableSelected']);
        Route::post(  'users/disableSelected',         ['as' => 'admin.users.disable-selected', 'uses' => 'UsersController@disableSelected']);
        Route::get(   'users/search',                  ['as' => 'admin.users.search',           'uses' => 'UsersController@searchByName']);
        Route::get(   'users/list',                    ['as' => 'admin.users.list',             'uses' => 'UsersController@listByPage']);
        Route::post(  'users/getInfo',                 ['as' => 'admin.users.get-info',         'uses' => 'UsersController@getInfo']);
        Route::post(  'users',                         ['as' => 'admin.users.store',            'uses' => 'UsersController@store']);
        Route::get(   'users',                         ['as' => 'admin.users.index',            'uses' => 'UsersController@index']);
        Route::get(   'users/create',                  ['as' => 'admin.users.create',           'uses' => 'UsersController@create']);
        Route::get(   'users/{userId}',                ['as' => 'admin.users.show',             'uses' => 'UsersController@show']);
        Route::patch( 'users/{userId}',                ['as' => 'admin.users.patch',            'uses' => 'UsersController@update']);
        Route::put(   'users/{userId}',                ['as' => 'admin.users.update',           'uses' => 'UsersController@update']);
        Route::delete('users/{userId}',                ['as' => 'admin.users.destroy',          'uses' => 'UsersController@destroy']);
        Route::get(   'users/{userId}/edit',           ['as' => 'admin.users.edit',             'uses' => 'UsersController@edit']);
        Route::get(   'users/{userId}/confirm-delete', ['as' => 'admin.users.confirm-delete',   'uses' => 'UsersController@getModalDelete']);
        Route::get(   'users/{userId}/delete',         ['as' => 'admin.users.delete',           'uses' => 'UsersController@destroy']);
        Route::get(   'users/{userId}/enable',         ['as' => 'admin.users.enable',           'uses' => 'UsersController@enable']);
        Route::get(   'users/{userId}/disable',        ['as' => 'admin.users.disable',          'uses' => 'UsersController@disable']);
        Route::get(   'users/{userId}/replayEdit',      ['as' => 'admin.users.replay-edit',      'uses' => 'UsersController@replayEdit']);
        // Role routes
        Route::post(  'roles/enableSelected',          ['as' => 'admin.roles.enable-selected',  'uses' => 'RolesController@enableSelected']);
        Route::post(  'roles/disableSelected',         ['as' => 'admin.roles.disable-selected', 'uses' => 'RolesController@disableSelected']);
        Route::get(   'roles/search',                  ['as' => 'admin.roles.search',           'uses' => 'RolesController@searchByName']);
        Route::post(  'roles/getInfo',                 ['as' => 'admin.roles.get-info',         'uses' => 'RolesController@getInfo']);
        Route::post(  'roles',                         ['as' => 'admin.roles.store',            'uses' => 'RolesController@store']);
        Route::get(   'roles',                         ['as' => 'admin.roles.index',            'uses' => 'RolesController@index']);
        Route::get(   'roles/create',                  ['as' => 'admin.roles.create',           'uses' => 'RolesController@create']);
        Route::get(   'roles/{roleId}',                ['as' => 'admin.roles.show',             'uses' => 'RolesController@show']);
        Route::patch( 'roles/{roleId}',                ['as' => 'admin.roles.patch',            'uses' => 'RolesController@update']);
        Route::put(   'roles/{roleId}',                ['as' => 'admin.roles.update',           'uses' => 'RolesController@update']);
        Route::delete('roles/{roleId}',                ['as' => 'admin.roles.destroy',          'uses' => 'RolesController@destroy']);
        Route::get(   'roles/{roleId}/edit',           ['as' => 'admin.roles.edit',             'uses' => 'RolesController@edit']);
        Route::get(   'roles/{roleId}/confirm-delete', ['as' => 'admin.roles.confirm-delete',   'uses' => 'RolesController@getModalDelete']);
        Route::get(   'roles/{roleId}/delete',         ['as' => 'admin.roles.delete',           'uses' => 'RolesController@destroy']);
        Route::get(   'roles/{roleId}/enable',         ['as' => 'admin.roles.enable',           'uses' => 'RolesController@enable']);
        Route::get(   'roles/{roleId}/disable',        ['as' => 'admin.roles.disable',          'uses' => 'RolesController@disable']);
        // Menu routes
        Route::post(  'menus',                         ['as' => 'admin.menus.save',             'uses' => 'MenusController@save']);
        Route::get(   'menus',                         ['as' => 'admin.menus.index',            'uses' => 'MenusController@index']);
        Route::get(   'menus/getData/{menuId}',        ['as' => 'admin.menus.get-data',         'uses' => 'MenusController@getData']);
        Route::get(   'menus/{menuId}/confirm-delete', ['as' => 'admin.menus.confirm-delete',   'uses' => 'MenusController@getModalDelete']);
        Route::get(   'menus/{menuId}/delete',         ['as' => 'admin.menus.delete',           'uses' => 'MenusController@destroy']);
        // Modules routes
        Route::get(   'modules',                               ['as' => 'admin.modules.index',                'uses' => 'ModulesController@index']);
        Route::get(   'modules/{slug}/initialize',             ['as' => 'admin.modules.initialize',           'uses' => 'ModulesController@initialize']);
        Route::get(   'modules/{slug}/confirm-uninitialize',   ['as' => 'admin.modules.confirm-uninitialize', 'uses' => 'ModulesController@getModalUninitialize']);
        Route::get(   'modules/{slug}/uninitialize',           ['as' => 'admin.modules.uninitialize',         'uses' => 'ModulesController@uninitialize']);
        Route::get(   'modules/{slug}/enable',                 ['as' => 'admin.modules.enable',               'uses' => 'ModulesController@enable']);
        Route::get(   'modules/{slug}/disable',                ['as' => 'admin.modules.disable',              'uses' => 'ModulesController@disable']);
        Route::post(  'modules/enableSelected',                ['as' => 'admin.modules.enable-selected',      'uses' => 'ModulesController@enableSelected']);
        Route::post(  'modules/disableSelected',               ['as' => 'admin.modules.disable-selected',     'uses' => 'ModulesController@disableSelected']);
        Route::get(   'modules/optimize',                      ['as' => 'admin.modules.optimize',             'uses' => 'ModulesController@optimize']);
        // Permission routes
        Route::get(   'permissions/generate',                      ['as' => 'admin.permissions.generate',         'uses' => 'PermissionsController@generate']);
        Route::post(  'permissions/enableSelected',                ['as' => 'admin.permissions.enable-selected',  'uses' => 'PermissionsController@enableSelected']);
        Route::post(  'permissions/disableSelected',               ['as' => 'admin.permissions.disable-selected', 'uses' => 'PermissionsController@disableSelected']);
        Route::post(  'permissions',                               ['as' => 'admin.permissions.store',            'uses' => 'PermissionsController@store']);
        Route::get(   'permissions',                               ['as' => 'admin.permissions.index',            'uses' => 'PermissionsController@index']);
        Route::get(   'permissions/create',                        ['as' => 'admin.permissions.create',           'uses' => 'PermissionsController@create']);
        Route::get(   'permissions/{permissionId}',                ['as' => 'admin.permissions.show',             'uses' => 'PermissionsController@show']);
        Route::patch( 'permissions/{permissionId}',                ['as' => 'admin.permissions.patch',            'uses' => 'PermissionsController@update']);
        Route::put(   'permissions/{permissionId}',                ['as' => 'admin.permissions.update',           'uses' => 'PermissionsController@update']);
        Route::delete('permissions/{permissionId}',                ['as' => 'admin.permissions.destroy',          'uses' => 'PermissionsController@destroy']);
        Route::get(   'permissions/{permissionId}/edit',           ['as' => 'admin.permissions.edit',             'uses' => 'PermissionsController@edit']);
        Route::get(   'permissions/{permissionId}/confirm-delete', ['as' => 'admin.permissions.confirm-delete',   'uses' => 'PermissionsController@getModalDelete']);
        Route::get(   'permissions/{permissionId}/delete',         ['as' => 'admin.permissions.delete',           'uses' => 'PermissionsController@destroy']);
        Route::get(   'permissions/{permissionId}/enable',         ['as' => 'admin.permissions.enable',           'uses' => 'PermissionsController@enable']);
        Route::get(   'permissions/{permissionId}/disable',        ['as' => 'admin.permissions.disable',          'uses' => 'PermissionsController@disable']);
        // Route routes
        Route::get(   'routes/load',                     ['as' => 'admin.routes.load',             'uses' => 'RoutesController@load']);
        Route::post(  'routes/enableSelected',           ['as' => 'admin.routes.enable-selected',  'uses' => 'RoutesController@enableSelected']);
        Route::post(  'routes/disableSelected',          ['as' => 'admin.routes.disable-selected', 'uses' => 'RoutesController@disableSelected']);
        Route::post(  'routes/savePerms',                ['as' => 'admin.routes.save-perms',       'uses' => 'RoutesController@savePerms']);
        Route::get(   'routes/search',                   ['as' => 'admin.routes.search',           'uses' => 'RoutesController@searchByName']);
        Route::post(  'routes/getInfo',                  ['as' => 'admin.routes.get-info',         'uses' => 'RoutesController@getInfo']);
        Route::post(  'routes',                          ['as' => 'admin.routes.store',            'uses' => 'RoutesController@store']);
        Route::get(   'routes',                          ['as' => 'admin.routes.index',            'uses' => 'RoutesController@index']);
        Route::get(   'routes/create',                   ['as' => 'admin.routes.create',           'uses' => 'RoutesController@create']);
        Route::get(   'routes/{routeId}',                ['as' => 'admin.routes.show',             'uses' => 'RoutesController@show']);
        Route::patch( 'routes/{routeId}',                ['as' => 'admin.routes.patch',            'uses' => 'RoutesController@update']);
        Route::put(   'routes/{routeId}',                ['as' => 'admin.routes.update',           'uses' => 'RoutesController@update']);
        Route::delete('routes/{routeId}',                ['as' => 'admin.routes.destroy',          'uses' => 'RoutesController@destroy']);
        Route::get(   'routes/{routeId}/edit',           ['as' => 'admin.routes.edit',             'uses' => 'RoutesController@edit']);
        Route::get(   'routes/{routeId}/confirm-delete', ['as' => 'admin.routes.confirm-delete',   'uses' => 'RoutesController@getModalDelete']);
        Route::get(   'routes/{routeId}/delete',         ['as' => 'admin.routes.delete',           'uses' => 'RoutesController@destroy']);
        Route::get(   'routes/{routeId}/enable',         ['as' => 'admin.routes.enable',           'uses' => 'RoutesController@enable']);
        Route::get(   'routes/{routeId}/disable',        ['as' => 'admin.routes.disable',          'uses' => 'RoutesController@disable']);
        // Audit routes
        Route::get( 'audit',                           ['as' => 'admin.audit.index',             'uses' => 'AuditsController@index']);
        Route::get( 'audit/purge',                     ['as' => 'admin.audit.purge',             'uses' => 'AuditsController@purge']);
        Route::get( 'audit/{auditId}/replay',          ['as' => 'admin.audit.replay',            'uses' => 'AuditsController@replay']);
        Route::get( 'audit/{auditId}/show',            ['as' => 'admin.audit.show',              'uses' => 'AuditsController@show']);
        // Error routes
        Route::get( 'errors',                          ['as' => 'admin.errors.index',             'uses' => 'ErrorsController@index']);
        Route::get( 'errors/purge',                    ['as' => 'admin.errors.purge',             'uses' => 'ErrorsController@purge']);
        Route::get( 'errors/{errorId}/show',           ['as' => 'admin.errors.show',              'uses' => 'ErrorsController@show']);
        // Settings routes
        Route::post(  'settings',                             ['as' => 'admin.settings.store',            'uses' => 'SettingsController@store']);
        Route::get(   'settings',                             ['as' => 'admin.settings.index',            'uses' => 'SettingsController@index']);
        Route::get(   'settings/load',                        ['as' => 'admin.settings.load',             'uses' => 'SettingsController@load']);
        Route::get(   'settings/create',                      ['as' => 'admin.settings.create',           'uses' => 'SettingsController@create']);
        Route::get(   'settings/{settingKey}',                ['as' => 'admin.settings.show',             'uses' => 'SettingsController@show']);
        Route::patch( 'settings/{settingKey}',                ['as' => 'admin.settings.patch',            'uses' => 'SettingsController@update']);
        Route::put(   'settings/{settingKey}',                ['as' => 'admin.settings.update',           'uses' => 'SettingsController@update']);
        Route::delete('settings/{settingKey}',                ['as' => 'admin.settings.destroy',          'uses' => 'SettingsController@destroy']);
        Route::get(   'settings/{settingKey}/edit',           ['as' => 'admin.settings.edit',             'uses' => 'SettingsController@edit']);
        Route::get(   'settings/{settingKey}/confirm-delete', ['as' => 'admin.settings.confirm-delete',   'uses' => 'SettingsController@getModalDelete']);
        Route::get(   'settings/{settingKey}/delete',         ['as' => 'admin.settings.delete',           'uses' => 'SettingsController@destroy']);

    }); // End of ADMIN group

    // Unisharp upload routes
    Route::group(['prefix' => 'registry'], function (){
        Route::get('/laravel-filemanager', 'FileManagement\LfmController@show');
        Route::post('/laravel-filemanager/upload', 'FileManagement\LfmController@upload');

        // \Unisharp\Laravelfilemanager\controllers
        // list all lfm routes here...

        // @cpnwaugha: I decided not to scaffold the Controllers so as to reduce the app size
        // am using the controllers from the LFM package.
        // Show LFM 
        Route::get('/', ['uses' => 'FileManagement\LfmController@show', 'as' => 'registry.show']);

        // Show integration error messages
        Route::get('/errors', ['uses' => 'FileManagement\LfmController@getErrors', 'as' => 'registry.get.errors']);

        // upload
        Route::any('/upload', ['uses' => 'FileManagement\UploadController@upload', 'as' => 'registry.upload']);

        // list images & files
        Route::get('/jsonitems', ['uses' => 'FileManagement\ItemsController@getItems', 'as' => 'registry.get.items']);

        // folders
        Route::get('/newfolder', ['uses' => 'FileManagement\FolderController@getAddfolder', 'as' => 'registry.get.addfolder']);
        Route::get('/deletefolder', ['uses' => 'FileManagement\FolderController@getDeletefolder', 'as' => 'regisrty.get.deletefolder']);
        Route::get('/folders', ['uses' => 'FileManagement\FolderController@getFolders', 'as' => 'registry.get.folders']);

        // move
        Route::get('/move', ['uses' => 'FileManagement\RenameController@getMove', 'as' => 'getMove']);

        // crop
        Route::get('/crop', ['uses' => 'FileManagement\CropController@getCrop', 'as' => 'getCrop']);
        Route::get('/cropimage', ['uses' => 'FileManagement\CropController@getCropimage', 'as' => 'registry.get.cropimage'
        ]);

        // rename
        Route::get('/rename', ['uses' => 'FileManagement\RenameController@getRename', 'as' => 'registry.get.rename']);
        // scale/resize
        Route::get('/resize', ['uses' => 'FileManagement\ResizeController@getResize', 'as' => 'registry.get.resize'
        ]);
        Route::get('/doresize', ['uses' => 'FileManagement\ResizeController@performResize', 'as' => 'registry.perform.resize']);
        // download
        Route::get('/download', ['uses' => 'FileManagement\DownloadController@getDownload', 'as' => 'registry.get.download'
        ]);

        // delete
        Route::get('/delete', ['uses' => 'FileManagement\DeleteController@getDelete', 'as' => 'registry.get.delete']);

        Route::get('/demo', 'FileManagement\DemoController@index');

        // @cpnwaugha: c-e: confirm that this is going to the public dir.
        // Get file when base_directory isn't public
        $images_url = '/' . \Config::get('lfm.images_folder_name') . '/{base_path}/{image_name}';
        $files_url = '/' . \Config::get('lfm.files_folder_name') . '/{base_path}/{file_name}';
        Route::get($images_url, 'FileManagement\RedirectController@getImage')
            ->where('image_name', '.*');
        Route::get($files_url, 'FileManagement\RedirectController@getFile')
            ->where('file_name', '.*');

    }); // end of Registry Group

    // Uncomment to enable Rapyd datagrid.
//    require __DIR__.'/rapyd.php';

}); // end of AUTHORIZE middleware group