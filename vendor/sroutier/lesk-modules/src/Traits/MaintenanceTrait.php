<?php namespace Sroutier\LESKModules\Traits;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Route;
use Artisan;
use File;

trait MaintenanceTrait
{

    /**
     * Locate menu and disable it.
     *
     * @param $name
     */
    protected static function disableMenu($name)
    {
        //
        $menu = Menu::where('name', $name)->first();
        if ($menu) {
            $menu->enabled = false;
            $menu->save();
        }
    }


    /**
     * Locate menu and enable it.
     *
     * @param $name
     */
    protected static function enableMenu($name)
    {
        $menu = Menu::where('name', $name)->first();
        if ($menu) {
            $menu->enabled = true;
            $menu->save();
        }
    }


    /**
     * Locate menu and delete it if it does not contain
     * any other sub-menu entries.
     *
     * @param $name
     */
    protected static function destroyMenu($name)
    {
        $menu = Menu::where('name', $name)->first();
        if ( ($menu) && (!$menu->children->count()) ) {
            Menu::destroy($menu->id);
        }
    }

    /**
     * Call the migration rollback command.
     *
     * @param $slug
     */
    protected static function rollbackMigration($slug)
    {
        Artisan::call('module:migrate:rollback', ['slug' => $slug, '--force' => true]);
    }


    /**
     * Call the migration command.
     *
     * @param $slug
     */
    protected static function migrate($slug)
    {
        Artisan::call('module:migrate', ['slug' => $slug, '--force' => true]);
    }


    /**
     * Call the seed command
     *
     * @param $slug
     */
    protected static function seed($slug)
    {
        Artisan::call('module:seed',    ['slug' => $slug, '--force' => true]);
    }


    /**
     * Call the publish
     *
     * @param $slug
     */
    protected static function publishAsset($nameSpace, $slug)
    {
        // Can't use the artisan publish command since the module is uninitialiazed & disabled the
        // Provider will not be registered and booted.
        // So we have to build our own deploy function.
        $assetsSource = config('modules.path') . '/' . $nameSpace . '/assets';
        $assetsTarget = config('modules.path_public_assets') . '/' . $slug;
        File::copyDirectory($assetsSource, $assetsTarget);
    }


    /**
     * Locate role, detach from perms and users then delete.
     *
     * @param $name
     */
    protected static function destroyRole($name)
    {
        $roleActiveDirectoryInspector = Role::where('name', $name)->first();
        if ($roleActiveDirectoryInspector) {
            $roleActiveDirectoryInspector->perms()->detach();
            $roleActiveDirectoryInspector->users()->detach();
            Role::destroy($roleActiveDirectoryInspector->id);
        }
    }


    /**
     * Locate module routes, dissociate from perms and delete
     *
     * @param $string
     */
    protected static function destroyRoute($name)
    {
        $routeShow = Route::where('name', $name)->first();
        if ($routeShow) {
            $routeShow->permission()->dissociate();
            Route::destroy($routeShow->id);
        }
    }


    /**
     * Locate module permission and delete it.
     *
     * @param $string
     */
    protected static function destroyPermission($name)
    {
        $permUseActiveDirectoryInspector = Permission::where('name', $name)->first();
        if ($permUseActiveDirectoryInspector) {
            Permission::destroy($permUseActiveDirectoryInspector->id);
        }
    }


    /**
     * Creates a Route and returns it.
     *
     * @param $name
     * @param $path
     * @param $action_name
     * @param string $method
     * @param bool $enabled
     * @return \App\Models\Route
     */
    protected static function createRoute($name, $path, $action_name, $permission = null, $method = 'GET', $enabled = true)
    {
        $route = Route::firstOrCreate([
            'name'          => $name,
            'path'          => $path,
            'action_name'   => $action_name,
            'method'        => $method,
            'enabled'       => $enabled,
        ]);

        if (!is_null($permission)) {
            $permission = Permission::resolve($permission);
            if (!is_null($permission)) {
                $route->permission()->associate($permission);
                $route->save();
            }
        }
        return $route;
    }


    /**
     * Creates a Permission and returns it.
     *
     * @param $name
     * @param $display_name
     * @param $description
     * @param bool $enabled
     * @return \App\Models\Permission
     */
    protected static function createPermission($name, $display_name, $description, $enabled = true)
    {
        $permUseActiveDirectoryInspector = Permission::firstOrCreate([
            'name'          => $name,
            'display_name'  => $display_name,
            'description'   => $description,
            'enabled'       => $enabled,
        ]);
        return $permUseActiveDirectoryInspector;
    }


    /**
     * Creates a Role and returns it.
     *
     * @param $name
     * @param $display_name
     * @param $description
     * @param bool $enabled
     * @return \App\Models\Role
     */
    protected static function createRole($name, $display_name, $description, $permissions = null, $enabled = true)
    {
        $role = Role::firstOrCreate([
            'name'          => $name,
            'display_name'  => $display_name,
            'description'   => $description,
            'enabled'       => $enabled,
        ]);

        if ( (!is_null($role)) && is_array($permissions) ) {
            $role->perms()->sync($permissions);
        }

        return $role;
    }


    protected static function createMenu($name, $label, $position = 999, $icon = 'fa fa-file', $parent = 'root', $enabled = false,
                                         $route = null, $permission = null, $url = null, $separator = false)
    {
        $parent_id = self::getParentMenuID($parent);
        $route_id = self::getRouteID($route);
        $permission_id = self::getPermissionID($permission);

        $menu = Menu::firstOrCreate([
            'name'          => $name,
            'label'         => $label,
            'position'      => $position,
            'icon'          => $icon,
            'parent_id'     => $parent_id,
            'route_id'      => $route_id,
            'permission_id' => $permission_id,
            'url'           => $url,
            'separator'     => $separator,
            'enabled'       => $enabled,
        ]);
        return $menu;
    }



    /**
     * Resolve the parent menu item and return it's ID.
     * Default to the 'root' menu item if no match can be found.
     *
     * @param $parent
     * @return mixed
     */
    protected static function getParentMenuID($parent)
    {
        // Set the parent id to be root by default.
        $parent_id = Menu::where('name', 'root')->first()->id;

//        // If a string was provided, find the Menu based on that name.
//        if (is_string($parent)) {
//            $parent = Menu::where('name', $parent)->first();
//        }

        $parent = Menu::resolve($parent);

        // If a Menu object was provided or found in the previous block,
        // return the ID of that object.
        if ($parent instanceof Menu) {
            $parent_id = $parent->id;
        }

        return $parent_id;
    }



    /**
     * Resolve the route item and return it's ID.
     * Defaults to null if no match can be found.
     *
     * @param $parent
     * @return mixed
     */
    protected static function getRouteID($route)
    {
        $route_id = null;

//        // If a string was provided, find the Route based on that name.
//        if (is_string($route)) {
//            $route = Route::where('name', $route)->first();
//        }

        $route = Route::resolve($route);

        // If a Route object was provided or found in the previous block,
        // return the ID of that object.
        if ($route instanceof Route) {
            $route_id = $route->id;
        }

        return $route_id;
    }



    /**
     * Resolve the permission item and return it's ID.
     * Defaults to null if no match can be found.
     *
     * @param $parent
     * @return mixed
     */
    protected static function getPermissionID($permission)
    {
        $permission_id = null;

//        // If a string was provided, find the Permission based on that name.
//        if (is_string($permission)) {
//            $permission = Permission::where('name', $permission)->first();
//        }

        $permission = Permission::resolve($permission);

        // If a Permission object was provided or found in the previous block,
        // return the ID of that object.
        if ($permission instanceof Permission) {
            $permission_id = $permission->id;
        }

        return $permission_id;
    }

}
