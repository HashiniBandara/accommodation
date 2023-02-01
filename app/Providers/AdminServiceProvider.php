<?php

namespace App\Providers;

use App\Model\User;
use App\Model\Accommodation_type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = 'admin/home';

    /**
     * admin guard name.
     *
     * @var string
     */
    public const GUARD = 'admin';

    /**
     * admin back end login.
     *
     * @var string
     */
    public const BACKEND_LOGIN_ROUTE = 'admin.login';

    /**
     * admin back end login.
     *
     * @var string
     */
    public const BACKEND_LOGIN_URL = 'admin/login';

    /**
     * admin back end login.
     *
     * @var string
     */
    public const BACKEND_LOG_OUT_ROUTE = 'admin.logout';

    /**
     * admin back end dash board.
     *
     * @var string
     */
    public const BACKEND_DASHBOARD_ROUTE = 'admin.dashboard';

    /**
     * admin back end dash board url.
     *
     * @var string
     */
    public const BACKEND_DASHBOARD_URL = 'admin/dashboard';

    /**
     * admin backend permission route.
     *
     * @var string
     */
    public const PERMISSION_REQUIRED_ROUTE = 'admin.permission.required';

    /**
     * admin backend permission url.
     *
     * @var string
     */
    public const PERMISSION_REQUIRED_URL = 'admin/permission/required';

    /**
     * admin back end dash board url.
     *
     * @var string
     */
    public const PERMISSION_REQUIRED_MODULE = 'permission_required';

    /**
     * admin back end dash board url.
     *
     * @var string
     */
    public const IS_SUPER_ADMIN = 1;

    // passowrd reset routes start

    /**
     * @var string
     */
    public const PASSWORD_REQUEST_ROUTE = 'admin.password.request';

    /**
     * @var string
     */
    public const PASSWORD_EMAIL_ROUTE = 'admin.password.email';

    /**
     * @var string
     */
    public const PASSWORD_RESET_TOKEN_ROUTE = 'admin.password.reset.token.email';

    /**
     * @var string
     */
    public const PASSWORD_RESET_UPDATE_ROUTE = 'admin.password.update';

    // end passowrd reset routes start

    /**
     * @var string
     */
    public const AUTH_MIDDLEWARE = 'auth.admin'; // used for only logged routes

    /**
     * @var string
     */
    public const MIDDLEWARE_NAME = 'admin'; // used for only logged routes

    /**
     * Get permission for permission listing
     *
     * @var string
     */
    public const IS_LIST = TRUE;

    /**
     * @var string
     */
    public const PERMISSION_LIST_ROUTE = 'admin.permission.list';

    /**
     * @var string
     */
    public const PERMISSION_LIST_AJAX_ROUTE = 'admin.permission.list.ajax';

    /**
     * @var string
     */
    public const PERMISSION_DELETE_ROUTE = 'admin.permission.delete';

    /**
     * @var string
     */
    public const USER_ROLE_LIST_ROUTE = 'admin.user.role.list';

    /**
     * @var string
     */
    public const USER_ROLE_SUBMIT_ROUTE = 'admin.user.role.submit';

    /**
     * @var string
     */
    public const USER_ROLE_CREATE_ROUTE = 'admin.user.role.create';

    /**
     * @var string
     */
    public const USER_ROLE_EDIT_ROUTE = 'admin.user.role.edit';

    /**
     * @var string
     */
    public const USER_ROLE_EDIT_SUBMIT_ROUTE = 'admin.user.role.edit.submit';

    /**
     * @var string
     */
    public const USER_ROLE_LIST_AJAX_ROUTE = 'admin.user.role.list.ajax';

    /**
     * @var string
     */
    public const USER_ROLE_DELETE_ROUTE = 'admin.user.role.delete';

    /**
     * @var string
     */
    public const PERMISSION_DELETE_SUCSESS_MSG = 'Permission has been successfully deleted.';

    /**
     * @var string
     */
    public const PERMISSION_DELETE_FAILED_MSG = "An error occurred while deleting this permission";

    /**
     * @var string
     */
    public const USER_ROLE_DELETE_SUCSESS_MSG = 'The user role has been successfully deleted.';

    /**
     * @var string
     */
    public const USER_ROLE_ENBALE_SUCSESS_MSG = 'The user role has been successfully activated.';

    /**
     * @var string
     */
    public const USER_ROLE_DELETE_FAILED_MSG = "An error occurred while updating this user role.";

    /**
     * @var string
     */
    public const USER_ROLE_DELETE_USED_MSG = "The selected role cannot be deleted, as it is already assigned to users.";

    /**
     * @var string
     */
    public const USER_ROLE_CREATE_FAILED_MSG = "An error occurred while saving this user role.";

    /**
     * @var string
     */
    public const USER_ROLE_UPDATE_FAILED_MSG = "An error occurred while updating this user role.";

    /**
     * @var string
     */
    public const USER_ROLE_PERMISSION_UPDATE_FAILED_MSG = "An error occurred while updating this user role permissions.";

    /**
     * @var string
     */
    public const USER_ROLE_CREATE_SUCCESS_MSG = "Role has been successfully added.";

    /**
     * @var string
     */
    public const USER_ROLE_UPDATE_SUCCESS_MSG = "Role has been successfully updated.";

    /**
     * @var string
     */
    public const USER_LIST_ROUTE = 'admin.user.list';

    /**
     * @var string
     */
    public const USER_CREATE_ROUTE = 'admin.user.create';

    /**
     * @var string
     */
    public const USER_CREATE_FAILED_MSG = "An error occurred while saving this user .";

    /**
     * @var string
     */
    public const USER_LIST_AJAX_ROUTE = 'admin.user.list.ajax';

    /**
     * @var string
     */
    public const USER_EDIT_ROUTE = 'admin.user.edit';

    /**
     * @var string
     */
    public const USER_PROFILE_EDIT_ROUTE = 'admin.user.profile.edit';

    /**
     * @var string
     */
    public const USER_EDIT_SUBMIT_ROUTE = 'admin.user.edit.submit';

    /**
     * @var string
     */
    public const USER_CREATE_SUBMIT_ROUTE = 'admin.user.submit';

    /**
     * @var string
     */
    public const USER_DELETE_ROUTE = 'admin.user.delete';

    /**
     * @var string
     */
    public const USER_UPDATE_FAILED_MSG = "An error occurred while updating this user account.";

    /**
     * @var string
     */
    public const USER_CREATE_OK_MSG = "User has been successfully added.";

    /**
     * @var string
     */
    public const USER_UPDATE_OK_MSG = "User has been successfully updated.";

    /**
     * @var string
     */
    public const USER_DELETE_SUCSESS_MSG = 'The user has been successfully disabled.';

    /**
     * @var string
     */
    public const USER_ENBALE_SUCSESS_MSG = 'The user has been successfully activated.';

    /**
     * @var string
     */
    public const USER_DELETE_FAILED_MSG = "An error occurred while updating this user.";

    /**
     * @var string
     */
    public const USER_DELETE_USED_MSG = "The selected user cannot be deleted because this user has performed various activities.";

    // status start
    // common messages

    /**
     * @var string
     */
    public const NO_LONGER_EXISTS_MSG = 'This record no longer exists.';

    /**
     * @var string
     */
    public const NO_PERMISSION_MSG = 'You need more permissions to access this.';

    /**
     * @var string
     */
    public const UPLOAD_IMAGE_ROUTE = 'admin.image.store';

    /**
     * @var int
     */
    public const STATUS_ACTIVE = STATUS_ACTIVE;

    /**
     * @var int
     */
    public const STATUS_INACTIVE = STATUS_INACTIVE;

    /**
     * @var string
     */
    public const VALIDATION_FAILED_MSG = 'Validation error occured. Please try again.';

    /**
     * @var string //Accommodation type create/view
     */
    public const ACCOMMODATION_TYPE_CREATE_ROUTE = 'admin.accommodation.accommodation_type';

    /**
     * @var string //Accommodation type submit
     */
    public const ACCOMMODATION_TYPE_SUBMIT_ROUTE = 'admin.accommodation.accommodation_type_index'; //accommodation_type

    /**
     * @var string  //Accommodation list view
     */
    public const ACCOMMODATION_LIST_VIEW_ROUTE = 'admin.accommodation.list'; //accommodation_type_list accommodation_type_index

    /**
     * @var string  //Accommodation list ajax
     */
    public const ACCOMMODATION_LIST_AJAX_ROUTE = 'admin.accommodation.list.ajax';

    /**
     * @var string
     */
    public const ACCOMMODATION_LIST_DELETE_ROUTE = 'admin.accommodation.accommodation_type_delete';

    /**
     * @var string
     */
    public const ACCOMMODATION_LIST_EDIT_ROUTE = 'admin.accommodation.accommodation_type_edit';

    /**
     * @var string
     */
    // public const ACCOMMODATION_TYPE_UPDATE_ROUTE = 'admin.accommodation.update';
    public const ACCOMMODATION_TYPE_UPDATE_ROUTE = 'admin.accommodation.update';

//********************* */
/**
     * @var string
     */
    public const ACCOMMODATION_TYPE_UPDATE_FAILED_MSG = "An error occurred while updating this Accommodation type.";

    /**
     * @var string
     */
    public const ACCOMMODATION_TYPE_CREATE_OK_MSG = "Accommodation type has been successfully added.";

    /**
     * @var string
     */
    public const ACCOMMODATION_TYPE_UPDATE_OK_MSG = "Accommodation type has been successfully updated.";

    /**
     * @var string
     */
    public const ACCOMMODATION_TYPE_SUCSESS_MSG = 'The Accommodation type has been successfully disabled.';

    /**
     * @var string
     */
    public const ACCOMMODATION_TYPE_ENABLE_SUCSESS_MSG = 'The Accommodation type has been successfully activated.';

    /**
     * @var string
     */
    public const ACCOMMODATION_TYPE_DELETE_FAILED_MSG = "An error occurred while updating this Accommodation type.";

    /**
     * @var string
     */
    public const ACCOMMODATION_TYPE_DELETE_USED_MSG = "The selected Accommodation type cannot be deleted because this Accommodation type has performed various activities.";

//************************ */

    /**
     * @var string //Accommodation detail create/view
     */
    public const ACCOMMODATION_DETAILS_CREATE_ROUTE = 'admin.accommodation.accommodation_detail';

    /**
     * @var string //Accommodation type submit
     */
    public const ACCOMMODATION_DETAILS_SUBMIT_ROUTE = 'admin.accommodation.accommodation_detail_index'; //accommodation_type

 /**
     * @var string  //Accommodation list view
     */
    public const ACCOMMODATION_DETAILS_LIST_VIEW_ROUTE = 'admin.accommodation.accommodation_detail_list';//accommodation_type_list accommodation_type_index

      /**
     * @var string  //Accommodation list ajax
     */
    public const ACCOMMODATION_DETAILS_LIST_AJAX_ROUTE = 'admin.accommodation.accommodation_detail_list.ajax';

    /**
     * @var string  //ACCOMMODATION_DETAIL_LIST_DELETE_ROUTE
     */
    public const ACCOMMODATION_DETAIL_LIST_DELETE_ROUTE = 'admin.accommodation.delete';

    /**
     * @var string //ACCOMMODATION_DETAIL_LIST_EDIT_ROUTE
     */
    public const ACCOMMODATION_DETAIL_LIST_EDIT_ROUTE = 'admin.accommodation.accommodation_detail_edit';

    /**
     * @var string  //ACCOMMODATION_DETAIL_UPDATE_ROUTE
     */
    public const ACCOMMODATION_DETAIL_UPDATE_ROUTE = 'admin.accommodation.accommodation_detail_update';

    //********************* */
/**
     * @var string
     */
    public const ACCOMMODATION_DETAIL_UPDATE_FAILED_MSG = "An error occurred while updating this Accommodation detail.";

    /**
     * @var string
     */
    public const ACCOMMODATION_DETAIL_CREATE_OK_MSG = "Accommodation detail has been successfully added.";

    /**
     * @var string
     */
    public const ACCOMMODATION_DETAIL_UPDATE_OK_MSG = "Accommodation detail has been successfully updated.";

    /**
     * @var string
     */
    public const ACCOMMODATION_DETAIL_SUCSESS_MSG = 'The Accommodation detail has been successfully disabled.';

    /**
     * @var string
     */
    public const ACCOMMODATION_DETAIL_ENABLE_SUCSESS_MSG = 'The Accommodation detail has been successfully activated.';

    /**
     * @var string
     */
    public const ACCOMMODATION_DETAIL_DELETE_FAILED_MSG = "An error occurred while updating this Accommodation detail.";

    /**
     * @var string
     */
    public const ACCOMMODATION_DETAIL_DELETE_USED_MSG = "The selected Accommodation detail cannot be deleted because this Accommodation detail has performed various activities.";

//************************ */

    // status end

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Repositories services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * get the loged system user for back end
     *
     * @return User | boolean
     */
    public static function getAuthUser()
    {
        if (!Auth::guard(AdminServiceProvider::GUARD)->check()) {
            return FALSE;
        }
        $loged_user = Auth::guard(AdminServiceProvider::GUARD)->user();
        if (empty($loged_user)) {
            return FALSE;
        }

        return $loged_user;
    }

    /**
     * get the give role is used or not
     *
     * @param  int  $role_id
     * @return bool TRUE/FALSE
     */
    public static function isUsedRole($role_id)
    {
        $tableNames = config('permission.table_names');
        $modelHasRolesTableName = $tableNames['model_has_roles'];

        $usageCount = DB::table($modelHasRolesTableName)
            ->where('role_id', '=', $role_id)
            ->count();

        return $usageCount > 0;
    }

    /**
     * Gives whether one of the given permissions applies to the auth user or not
     * not check super admin
     *
     * @param  array  $route_names
     *
     * @return bool TRUE/FALSE
     */
    public static function hasAnyPermission($route_names)
    {
        $has = false;
        foreach ($route_names as $route_name) {
            $has = self::getAuthUserPermission($route_name);
            if ($has) break;
        }
        return $has;
    }

    /**
     * get the loged system user with permission for back end
     * not check super admin
     *
     * @param  string  $route_name
     * @param  string  $is_group
     *
     * @return bool TRUE/FALSE
     */
    public static function getAuthUserPermission($route_name, $is_group = '')
    {
        if (!Auth::guard(AdminServiceProvider::GUARD)->check()) {
            return FALSE;
        }
        $loged_user = Auth::guard(AdminServiceProvider::GUARD)->user();
        if (empty($loged_user)) {
            return FALSE;
        }

        $user = User::find($loged_user->id);
        if ($user->is_super_admin == AdminServiceProvider::IS_SUPER_ADMIN) {
            return TRUE;
        }
        $permissionsviaroles = $user->getPermissionsViaRoles()->toArray();
        $permissions = [];
        foreach ($permissionsviaroles as $permission) {
            $permissions[] = $permission['id'];
        }

        if ($is_group != '') {
            $permission_group = Permission::where([
                'deleted_at' => NULL,
                'guard_name' => AdminServiceProvider::GUARD,
                'module' => $is_group
            ])->get()->pluck('id')->toArray();

            if (empty($permission_group)) {
                return FALSE;
            }

            $has_any_pem = array_intersect($permissions, $permission_group);
            if (empty($has_any_pem)) {
                return FALSE;
            }
            return TRUE;
        }

        $permission = Permission::where([
            'deleted_at' => NULL,
            'guard_name' => AdminServiceProvider::GUARD,
            'real_route_name' => $route_name
        ])->get()->first();

        if (!empty($permission)) {
            $permission_id = intval($permission->id);
            if (in_array($permission_id, $permissions)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}
