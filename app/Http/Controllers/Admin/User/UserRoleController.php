<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Providers\AdminServiceProvider;
use App\Providers\CommonServiceProvider;
use App\Repositories\PermissionRepository;
use App\Repositories\UserRoleRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Str;
use Validator;

class UserRoleController extends Controller
{
    protected $search_columns = ["id", "name", "created_at", "status"];

    private $userRoleRepository;

    private $permissionRepository;

    private $modal_description = "Are you sure you wish to continue ?";

    private $modal_title = "Delete user role action";

    private $modal_add_title = "Add New User Role";

    private $modal_edit_title = "Update User Role";

    private $modal_status_title = "Change User Role status";


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRoleRepository $userRoleRepository, PermissionRepository $permissionRepository) {
        $this->userRoleRepository = $userRoleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user_role.index')
            ->with([
                'title' => 'User Roles',
                'modal_description' => $this->modal_description,
                'modal_title' => $this->modal_status_title,
                'modal_delete_route' => AdminServiceProvider::USER_ROLE_DELETE_ROUTE
            ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->permissionRepository->list()
            ->select(['id', 'name', 'module'])
            ->where('is_list', AdminServiceProvider::IS_LIST)
            ->where('deleted_at', NULL)
            ->orderBy('module', "ASC")
            ->orderBy('name', 'ASC')
            ->get();

        $permissions_list = [];
        if (!empty($permissions)) {
            foreach ($permissions as $permission) {
                $permissions_list[$permission->module][] = $permission;
            }
        }

        return view('admin.user_role.create')
            ->with([
                'title' => 'Create New user',
                'modal_description' => $this->modal_description,
                'modal_title' => $this->modal_add_title,
                'permissions' => $permissions_list
            ]);
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request)
    {
        $data_list = [];
        $data_list['draw'] = intval($request->draw);
        $data_list['recordsTotal'] = $this->userRoleRepository->rows_count();
        $roles = $this->userRoleRepository->getAllWithSearch($request, $this->search_columns);
        $data_list['recordsFiltered'] = $roles->count();

        $actions = '';
        if(AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::USER_ROLE_EDIT_ROUTE)) {
            $actions = $actions.'<a href="' . route(AdminServiceProvider::USER_ROLE_EDIT_ROUTE, ['id' => '::id']) . '" class="' . DT_BTN_CLASSES . ' btn-primary"><i class="fa fa-pen"></i></a>';
        }

        if(AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::USER_ROLE_DELETE_ROUTE)) {
            $actions = $actions . '<button data-id="::id" type="button" class="' . DT_BTN_CLASSES . ' btn-danger delete-btn"><i class="fa fa-trash"></i></button>';
        }

        $list = $roles->map(function ($role, $key) use ($actions) {
            $actions = str_replace("::id", $role->id, $actions);
            return [
                $role->id,
                $role->name,
                Carbon::parse($role->created_at)->format('Y-m-d h:i:s'),
                CommonServiceProvider::getStatus($role->status),
                $actions
            ];
        });
        $data_list['data'] = $list->toArray();

        return response()->json($data_list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'role_name' => 'required|regex:/^[\pL\s\-]+$/u|max:30|min:3|unique:roles,name,' . $request->role_name
        ], $this->messages());

        if ($validator->fails()) {
            return redirect()->route(AdminServiceProvider::USER_ROLE_CREATE_ROUTE)
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::USER_ROLE_CREATE_FAILED_MSG
                ])
                ->withErrors($validator)
                ->withInput();
        }

        $role_id = $this->userRoleRepository->store($request);
        if ($role_id) {
            $update_permissions = [];

            $default_permission = $this->permissionRepository->getPermissionRequiredRoute();
            if (!empty($default_permission)) {
                $update_permissions[] = [
                    'permission_id' => $default_permission->id,
                    'role_id' => $role_id
                ];
            }
            $coll_permissions = Str::of($request->create_role_permissions)->explode(',');
            if (!empty($coll_permissions)) {


                foreach ($coll_permissions as $permission) {

                    if (is_numeric($permission)) {
                        $parent_permissions = $this->permissionRepository->getParanetPermissions($permission);
                        if (!empty($parent_permissions)) {
                            foreach ($parent_permissions as $parent_permission) {
                                $update_permissions[] = [
                                    'permission_id' => $parent_permission->id,
                                    'role_id' => $role_id
                                ];
                            }
                        }

                        $update_permissions[] = [
                            'permission_id' => $permission,
                            'role_id' => $role_id
                        ];
                    }
                }
                $per_update = $this->permissionRepository->givePermissionTo($update_permissions);
                if (!$per_update) {
                    return redirect()->route(AdminServiceProvider::USER_ROLE_EDIT_ROUTE, ['id' => $role_id])
                        ->with([
                            'status' => FALSE,
                            'message' => AdminServiceProvider::USER_ROLE_PERMISSION_UPDATE_FAILED_MSG
                        ]);
                }
            }

            return redirect()->route(AdminServiceProvider::USER_ROLE_LIST_ROUTE)
                ->with([
                    'status' => TRUE,
                    'message' => AdminServiceProvider::USER_ROLE_CREATE_SUCCESS_MSG
                ]);
        }

        return redirect()->route(AdminServiceProvider::USER_ROLE_LIST_ROUTE)
            ->with([
                'status' => FALSE,
                'message' => AdminServiceProvider::USER_ROLE_CREATE_FAILED_MSG
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (empty($id)) {
            return redirect()->route(AdminServiceProvider::USER_ROLE_LIST_ROUTE)
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
                ]);
        }

        $role = $this->userRoleRepository->get($id);
        if (!$role) {
            return redirect()->route(AdminServiceProvider::USER_ROLE_LIST_ROUTE)
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
                ]);
        }

        $permissions = $this->permissionRepository->list()
            ->select(['id', 'name', 'module'])
            ->where('is_list', AdminServiceProvider::IS_LIST)
            ->where('deleted_at', NULL)
            ->orderBy('module', "ASC")
            ->orderBy('name', 'ASC')
            ->get();

        $permissions_list = [];
        if (!empty($permissions)) {
            foreach ($permissions as $permission) {
                $permissions_list[$permission->module][] = $permission;
            }
        }

        // role permissions
        $cur_permissions = [];
        if (!empty($role->permissions)) {
            foreach ($role->permissions as $role_permission) {
                $cur_permissions[] = $role_permission->id;
            }
        }

        return view('admin.user_role.edit')
            ->with([
                'title' => 'Edit User Role',
                'modal_description' => $this->modal_description,
                'modal_title' => $this->modal_edit_title,
                'role' => $role,
                'permissions' => $permissions_list,
                'cur_permissions' => $cur_permissions,
                'is_all_pem' => (count($cur_permissions) == count($permissions)) ? 0 : 1,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:30', 'min:3', Rule::unique('roles', 'name')->where(function ($query) use ($request) {
                return $query->where('id', '!=', $request->role_id);
            })]
        ], $this->messages());

        if ($validator->fails()) {

            return redirect()->route(AdminServiceProvider::USER_ROLE_EDIT_ROUTE, ['id' => $request->role_id])
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::USER_ROLE_UPDATE_FAILED_MSG
                ])
                ->withErrors($validator)
                ->withInput();
        }

        $role_id = $this->userRoleRepository->update($request);
        if (!$role_id) {
            return redirect()->route(AdminServiceProvider::USER_ROLE_EDIT_ROUTE, ['id' => $request->role_id])
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::USER_ROLE_UPDATE_FAILED_MSG
                ]);
        }

        // update permissions
        $coll_permissions = Str::of($request->update_role_permissions)->explode(',');
        $update_permissions = [];
        $default_permission = $this->permissionRepository->getPermissionRequiredRoute();
        if (!empty($default_permission)) {
            $update_permissions[] = [
                'permission_id' => $default_permission->id,
                'role_id' => $role_id
            ];
        }

        if (!empty($coll_permissions)) {

            foreach ($coll_permissions as $permission) {
                if (is_numeric($permission)) {
                    // getParanetPermissions
                    $parent_permissions = $this->permissionRepository->getParanetPermissions($permission);
                    if (!empty($parent_permissions)) {
                        foreach ($parent_permissions as $parent_permission) {
                            $update_permissions[] = [
                                'permission_id' => $parent_permission->id,
                                'role_id' => $role_id
                            ];
                        }
                    }
                    $update_permissions[] = [
                        'permission_id' => $permission,
                        'role_id' => $role_id
                    ];
                }
            }
        }
        $per_update = $this->permissionRepository->updatePermissionTo($update_permissions, $role_id);
        if (!$per_update) {
            return redirect()->route(AdminServiceProvider::USER_ROLE_EDIT_ROUTE, ['id' => $request->role_id])
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::USER_ROLE_PERMISSION_UPDATE_FAILED_MSG
                ]);
        }
        return redirect()->route(AdminServiceProvider::USER_ROLE_LIST_ROUTE)
            ->with([
                'status' => TRUE,
                'message' => AdminServiceProvider::USER_ROLE_UPDATE_SUCCESS_MSG
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (empty($request->r_id)) {
            return [
                'status' => FALSE,
                'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
            ];
        }

        $used = AdminServiceProvider::isUsedRole($request->r_id);
        if($used){
            return [
                'status' => FALSE,
                'message' => AdminServiceProvider::USER_ROLE_DELETE_USED_MSG
            ];
        }

        $deleted = $this->userRoleRepository->destroy($request);
        if ($deleted) {
            return [
                'status' => TRUE,
                'message' => AdminServiceProvider::USER_ROLE_DELETE_SUCSESS_MSG
            ];
        }

        return [
            'status' => FALSE,
            'message' => AdminServiceProvider::USER_ROLE_DELETE_FAILED_MSG
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    private function messages()
    {
        return [
            'role_name.required' => 'The Role Name is required.',
            'role_name.max' => 'The Role Name may not be greater than :max.',
            'role_name.min' => 'The Role Name may not be less than :min.',
            'role_name.regex' => 'The Role Name format is invalid.',
            'role_name.unique' => 'The Role Name has already been taken.'

        ];
    }
}
