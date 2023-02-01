<?php

// use App\Http\Controllers\Accommodation\AccommodationController;
// use App\Http\Controllers\Admin\Accommodation\AccommodationController as AccommodationAccommodationController;
use App\Http\Controllers\Admin\Accommodation\AccommodationTypeController;
use App\Providers\AdminServiceProvider;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Admin'], function () {
    Route::get('login', ['uses' => 'Auth\LoginController@showLoginForm'])->name(AdminServiceProvider::BACKEND_LOGIN_ROUTE);
    Route::post('login-submit', ['uses' => 'Auth\LoginController@login'])->name('admin.login.submit');
    Route::post('logout', ['uses' => 'Auth\LoginController@logout'])->name(AdminServiceProvider::BACKEND_LOG_OUT_ROUTE);

    /**
     * Password Reset Route(S)
     */
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name(AdminServiceProvider::PASSWORD_REQUEST_ROUTE);
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name(AdminServiceProvider::PASSWORD_EMAIL_ROUTE);
    Route::get('password/reset/{token}/{email}', 'Auth\ResetPasswordController@showResetForm')->name(AdminServiceProvider::PASSWORD_RESET_TOKEN_ROUTE);
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name(AdminServiceProvider::PASSWORD_RESET_UPDATE_ROUTE);

    Route::group(['middleware' => ['auth.admin']], function () {

        //permissions required page
        Route::get('permission/required', [
            'module' => 'permission_required', 'uses' => 'DashboardController@permission',
            'is_list' => FALSE, 'show_as' => ''
        ])->name(AdminServiceProvider::PERMISSION_REQUIRED_ROUTE);

        //BACK_END_DASH_BOARD
        Route::get('/dashboard', [
            'module' => 'dashboard', 'uses' => 'DashboardController@index',
            'is_list' => TRUE, 'show_as' => 'View'
        ])->name(AdminServiceProvider::BACKEND_DASHBOARD_ROUTE);

        /*
        * permissions routes
        */
        Route::get('permission/list', [
            'module' => 'permission', 'uses' => 'Permission\PermissionController@index',
            'is_list' => FALSE, 'show_as' => 'List'
        ])->name(AdminServiceProvider::PERMISSION_LIST_ROUTE);

        Route::post('permission/list/ajax', [
            'module' => 'permission', 'uses' => 'Permission\PermissionController@list',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . AdminServiceProvider::PERMISSION_LIST_ROUTE
        ])->name(AdminServiceProvider::PERMISSION_LIST_AJAX_ROUTE);

        Route::post('permission/delete', [
            'module' => 'permission', 'uses' => 'Permission\PermissionController@destroy',
            'is_list' => FALSE, 'show_as' => 'Delete', 'parent' => 'get.' . AdminServiceProvider::PERMISSION_LIST_ROUTE
        ])->name(AdminServiceProvider::PERMISSION_DELETE_ROUTE);

        /*
        * end permissions routes
        */

        /*
        * user role routes
        */
        Route::get('user-roles/list', [
            'module' => 'user_role', 'uses' => 'User\UserRoleController@index',
            'is_list' => TRUE, 'show_as' => 'List'
        ])->name(AdminServiceProvider::USER_ROLE_LIST_ROUTE);

        Route::get('user-role/create', [
            'module' => 'user_role', 'uses' => 'User\UserRoleController@create',
            'is_list' => TRUE, 'show_as' => 'Create'
        ])->name(AdminServiceProvider::USER_ROLE_CREATE_ROUTE);

        Route::get('user-role/edit/{id}', [
            'module' => 'user_role', 'uses' => 'User\UserRoleController@show',
            'is_list' => TRUE, 'show_as' => 'Edit'
        ])->name(AdminServiceProvider::USER_ROLE_EDIT_ROUTE);

        Route::post('user-role/submit', [
            'module' => 'user_role', 'uses' => 'User\UserRoleController@store',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . AdminServiceProvider::USER_ROLE_CREATE_ROUTE
        ])->name(AdminServiceProvider::USER_ROLE_SUBMIT_ROUTE);

        Route::post('user-role/update', [
            'module' => 'user_role', 'uses' => 'User\UserRoleController@update',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . AdminServiceProvider::USER_ROLE_EDIT_ROUTE
        ])->name(AdminServiceProvider::USER_ROLE_EDIT_SUBMIT_ROUTE);

        Route::post('user-role/list/ajax', [
            'module' => 'user_role', 'uses' => 'User\UserRoleController@list',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . AdminServiceProvider::USER_ROLE_LIST_ROUTE
        ])->name(AdminServiceProvider::USER_ROLE_LIST_AJAX_ROUTE);

        Route::post('user-role/delete', [
            'module' => 'user_role', 'uses' => 'User\UserRoleController@destroy',
            'is_list' => TRUE, 'show_as' => 'Delete', 'parent' => 'get.' . AdminServiceProvider::USER_ROLE_LIST_ROUTE
        ])->name(AdminServiceProvider::USER_ROLE_DELETE_ROUTE);

        /*
        * end user role routes
        */

        /*
        * user account routes
        */

        Route::get('user/list', [
            'module' => 'user', 'uses' => 'User\UserController@index',
            'is_list' => TRUE, 'show_as' => 'List'
        ])->name(AdminServiceProvider::USER_LIST_ROUTE);

        Route::post('user/list/ajax', [
            'module' => 'user', 'uses' => 'User\UserController@list',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . AdminServiceProvider::USER_LIST_ROUTE
        ])->name(AdminServiceProvider::USER_LIST_AJAX_ROUTE);

        Route::get('user/create', [
            'module' => 'user', 'uses' => 'User\UserController@create',
            'is_list' => TRUE, 'show_as' => 'Create'
        ])->name(AdminServiceProvider::USER_CREATE_ROUTE);

        Route::post('user/submit', [
            'module' => 'user', 'uses' => 'User\UserController@store',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . AdminServiceProvider::USER_CREATE_ROUTE
        ])->name(AdminServiceProvider::USER_CREATE_SUBMIT_ROUTE);

        Route::get('user/edit/{id}', [
            'module' => 'user', 'uses' => 'User\UserController@show',
            'is_list' => TRUE, 'show_as' => 'Edit'
        ])->name(AdminServiceProvider::USER_EDIT_ROUTE);

        // profile update skip pem
        Route::get('user/profile/edit/', [
            'module' => '', 'uses' => 'User\UserController@profile',
            'is_list' => FALSE, 'show_as' => ''
        ])->name(AdminServiceProvider::USER_PROFILE_EDIT_ROUTE);

        Route::post('user/update', [
            'module' => '', 'uses' => 'User\UserController@update',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . AdminServiceProvider::USER_PROFILE_EDIT_ROUTE
        ])->name(AdminServiceProvider::USER_EDIT_SUBMIT_ROUTE);

        Route::post('user/delete', [
            'module' => 'user', 'uses' => 'User\UserController@destroy',
            'is_list' => TRUE, 'show_as' => 'Delete', 'parent' => 'get.' . AdminServiceProvider::USER_LIST_ROUTE
        ])->name(AdminServiceProvider::USER_DELETE_ROUTE);

        /*
        * end user account routes
        */

        /*
        * accommodation routes
        */
        Route::get('accommodation/accommodation_type', [
            'module' => 'accommodation', 'uses' => 'Accommodation\AccommodationTypeController@index',
            'is_list' => TRUE, 'show_as' => 'List'
        ])->name(AdminServiceProvider::ACCOMMODATION_TYPE_CREATE_ROUTE);

        //ACCOMMODATION_TYPE_SUBMIT_ROUTE
        Route::post('accommodation/accommodation_type_index', [
            'module' => 'accommodation', 'uses' => 'Accommodation\AccommodationTypeController@store',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . AdminServiceProvider::ACCOMMODATION_TYPE_CREATE_ROUTE
        ])->name(AdminServiceProvider::ACCOMMODATION_TYPE_SUBMIT_ROUTE);

        Route::get('accommodation/list', [ //accommodation_type_index_list  accommodation_type_list
            'module' => 'accommodation', 'uses' => 'Accommodation\AccommodationTypeController@accommodation_type_index',
            'is_list' => TRUE, 'show_as' => 'List'
        ])->name(AdminServiceProvider::ACCOMMODATION_LIST_VIEW_ROUTE);

        Route::post('accommodation/list/ajax', [
            'module' => 'accommodation', 'uses' => 'Accommodation\AccommodationTypeController@list',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . AdminServiceProvider::ACCOMMODATION_LIST_VIEW_ROUTE
        ])->name(AdminServiceProvider::ACCOMMODATION_LIST_AJAX_ROUTE);

        Route::post('accommodation/accommodation_type_delete', [
            'module' => 'accommodation', 'uses' => 'Accommodation\AccommodationTypeController@destroy',
            'is_list' => TRUE, 'show_as' => 'Delete', 'parent' => 'get.' . AdminServiceProvider::ACCOMMODATION_LIST_VIEW_ROUTE
        ])->name(AdminServiceProvider::ACCOMMODATION_LIST_DELETE_ROUTE);

        Route::get('accommodation/accommodation_type_edit/{id}', [
            'module' => 'user', 'uses' => 'Accommodation\AccommodationTypeController@show',
            'is_list' => TRUE, 'show_as' => 'Edit'
        ])->name(AdminServiceProvider::ACCOMMODATION_LIST_EDIT_ROUTE);

        //ACCOMMODATION_TYPE_UPDATE_ROUTE
        Route::post('accommodation/update', [
            'module' => '', 'uses' => 'Accommodation\AccommodationTypeController@update',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . AdminServiceProvider::ACCOMMODATION_LIST_EDIT_ROUTE
        ])->name(AdminServiceProvider::ACCOMMODATION_TYPE_UPDATE_ROUTE);

        //accommodation details
        Route::get('accommodation/accommodation_detail', [
            'module' => 'accommodation', 'uses' => 'Accommodation\AccommodationDetailController@index',
            'is_list' => TRUE, 'show_as' => 'List'
        ])->name(AdminServiceProvider::ACCOMMODATION_DETAILS_CREATE_ROUTE);

        //ACCOMMODATION_DETAILS_SUBMIT_ROUTE
        Route::post('accommodation/accommodation_detail_index', [
            'module' => 'accommodation', 'uses' => 'Accommodation\AccommodationDetailController@store',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . AdminServiceProvider::ACCOMMODATION_DETAILS_CREATE_ROUTE
        ])->name(AdminServiceProvider::ACCOMMODATION_DETAILS_SUBMIT_ROUTE);

        Route::get('accommodation/accommodation_detail_list', [ //accommodation_type_index_list  accommodation_type_list
            'module' => 'accommodation', 'uses' => 'Accommodation\AccommodationDetailController@accommodation_detail_index',
            'is_list' => TRUE, 'show_as' => 'List'
        ])->name(AdminServiceProvider::ACCOMMODATION_DETAILS_LIST_VIEW_ROUTE);

        Route::post('accommodation/accommodation_detail_list/ajax', [
            'module' => 'accommodation', 'uses' => 'Accommodation\AccommodationDetailController@accommodation_detail_list',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . AdminServiceProvider::ACCOMMODATION_DETAILS_LIST_VIEW_ROUTE
        ])->name(AdminServiceProvider::ACCOMMODATION_DETAILS_LIST_AJAX_ROUTE);

        //ACCOMMODATION_DETAIL_LIST_DELETE_ROUTE
        Route::post('accommodation/delete', [
            'module' => 'accommodation', 'uses' => 'Accommodation\AccommodationDetailController@destroy',
            'is_list' => TRUE, 'show_as' => 'Delete', 'parent' => 'get.' . AdminServiceProvider::ACCOMMODATION_DETAILS_LIST_VIEW_ROUTE
        ])->name(AdminServiceProvider::ACCOMMODATION_DETAIL_LIST_DELETE_ROUTE);

        Route::get('accommodation/accommodation_detail_edit/{id}', [
            'module' => 'accommodation', 'uses' => 'Accommodation\AccommodationDetailController@show',
            'is_list' => TRUE, 'show_as' => 'Edit'
        ])->name(AdminServiceProvider::ACCOMMODATION_DETAIL_LIST_EDIT_ROUTE);

        //ACCOMMODATION_DETAIL_UPDATE_ROUTE
        Route::post('accommodation/accommodation_detail_update', [
            'module' => '', 'accommodation' => 'Accommodation\AccommodationDetailController@update',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . AdminServiceProvider::ACCOMMODATION_DETAIL_LIST_EDIT_ROUTE
        ])->name(AdminServiceProvider::ACCOMMODATION_DETAIL_UPDATE_ROUTE);


        //end accommodation details



        Route::get('user/create', [
            'module' => 'user', 'uses' => 'User\UserController@create',
            'is_list' => TRUE, 'show_as' => 'Create'
        ])->name(AdminServiceProvider::USER_CREATE_ROUTE);

        Route::post('user/submit', [
            'module' => 'user', 'uses' => 'User\UserController@store',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . AdminServiceProvider::USER_CREATE_ROUTE
        ])->name(AdminServiceProvider::USER_CREATE_SUBMIT_ROUTE);

        Route::get('user/edit/{id}', [
            'module' => 'user', 'uses' => 'User\UserController@show',
            'is_list' => TRUE, 'show_as' => 'Edit'
        ])->name(AdminServiceProvider::USER_EDIT_ROUTE);

        // profile update skip pem
        Route::get('user/profile/edit/', [
            'module' => '', 'uses' => 'User\UserController@profile',
            'is_list' => FALSE, 'show_as' => ''
        ])->name(AdminServiceProvider::USER_PROFILE_EDIT_ROUTE);

        Route::post('user/update', [
            'module' => '', 'uses' => 'User\UserController@update',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . AdminServiceProvider::USER_PROFILE_EDIT_ROUTE
        ])->name(AdminServiceProvider::USER_EDIT_SUBMIT_ROUTE);

        Route::post('user/delete', [
            'module' => 'user', 'uses' => 'User\UserController@destroy',
            'is_list' => TRUE, 'show_as' => 'Delete', 'parent' => 'get.' . AdminServiceProvider::USER_LIST_ROUTE
        ])->name(AdminServiceProvider::USER_DELETE_ROUTE);
        /*
        * end accommodation routes
        */

        // start common function routes
        Route::post('store-image', [
            'module' => '', 'uses' => 'Common\CommonController@storeImage',
            'is_list' => FALSE, 'show_as' => ''
        ])->name(AdminServiceProvider::UPLOAD_IMAGE_ROUTE);
    });
});
