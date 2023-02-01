<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Mail\MayaMail;
use App\Providers\AdminServiceProvider;
use App\Providers\CommonServiceProvider;
use App\Repositories\SettingsRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Validator;

class UserController extends Controller
{
    protected $search_columns = ["id", "name", "first_name", "last_name", "email", "email", "status"];

    private $userRepository;

    private $userRoleRepository;

    private $settingsRepository;

    private $modal_description = "Are you sure you wish to continue ?";

    private $modal_title = "Delete user action";

    private $modal_add_title = "Add New User";

    private $modal_edit_title = "Update User";

    private $modal_status_title = "Change User status";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        UserRoleRepository $userRoleRepository,
        SettingsRepository $settingsRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->settingsRepository = $settingsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.user.index')
            ->with([
                'title' => 'Users',
                'modal_description' => $this->modal_description,
                'modal_title' => $this->modal_status_title,
                'modal_delete_route' => AdminServiceProvider::USER_DELETE_ROUTE
            ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->userRoleRepository->list()
            ->where('deleted_at', NULL)
            ->where('status', AdminServiceProvider::STATUS_ACTIVE)
            ->orderBy("name", "ASC")
            ->get();

        return view('admin.user.create')
            ->with([
                'title' => 'Create New User',
                'modal_description' => $this->modal_description,
                'modal_title' => $this->modal_add_title,
                'roles' => $roles
            ]);
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {

        $data_list = [];
        $data_list['draw'] = intval($request->draw);
        $data_list['recordsTotal'] = $this->userRepository->rows_count();

        $users = $this->userRepository->list()
            ->where('is_super_admin', 0)
            ->skip($request->start)
            ->take($request->length)
            ->where(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    foreach ($this->search_columns as $col) {
                        $query->orWhere($col, 'like', '%' . $request->search['value'] . '%');
                    }
                }
            })
            ->orderBy($this->search_columns[$request->order[0]['column']], $request->order[0]['dir'])
            ->get();

        if (empty($request->search['value'])) {
            $data_list['recordsFiltered'] = $this->userRepository->rows_count();
        } else {
            $data_list['recordsFiltered'] = count($users);
        }

        if (!empty($users)) {
            $user_list = [];
            foreach ($users as $key => $user) {
                $actions = '';
                if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::USER_EDIT_ROUTE)) {
                    $actions = $actions . '<a href="' . route(AdminServiceProvider::USER_EDIT_ROUTE, ['id' => $user->id]) . '" class="' . DT_BTN_CLASSES . ' btn-primary"><i class="fa fa-pen"></i></a>';
                }

                if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::USER_DELETE_ROUTE)) {

                    $actions = $actions . '<button ' . (AdminServiceProvider::getAuthUser()->id == $user->id ? 'disabled' : '') . ' data-id="' . $user->id . '" type="button" class="' . DT_BTN_CLASSES . ' btn-danger delete-btn"><i class="fa fa-trash"></i></button>';
                }

                $user_list[] = [
                    ($user->id),
                    $user->first_name,
                    $user->last_name,
                    $user->email,
                    isset($user->roles->pluck('name')[0]) ? $user->roles->pluck('name')[0] : '',
                    CommonServiceProvider::getStatus($user->status),
                    $actions
                ];
            }
            $data_list['data'] = $user_list;
        }

        return response()->json($data_list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'user_role' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'same:confirmed'],
        ], $this->messages());

        if ($validator->fails()) {
            return redirect()->route(AdminServiceProvider::USER_CREATE_ROUTE)
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::VALIDATION_FAILED_MSG
                ])
                ->withErrors($validator)
                ->withInput();
        }

        $userID = $this->userRepository->store($request);

        $role_update = $this->userRepository->update_role($userID, $request->user_role);

        if (!$role_update) {
            return redirect()->route(AdminServiceProvider::USER_CREATE_ROUTE)
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::USER_CREATE_FAILED_MSG
                ]);
        }

        if ($userID) {

            if ($request->notify_user) {
                $emailSubject = $this->settingsRepository->getValue(config('settings.email_key'), 'new_system_user_email_subject');
                $emailBody = $this->settingsRepository->getValue(config('settings.email_key'), 'new_system_user_email');

                $user = $this->userRepository->get($userID);

                $emailBody = CommonServiceProvider::getFormattedEmailBody($emailBody, array(
                    '[[full_name]]'     => $user->first_name . ' ' . $user->last_name,
                    '[[user_email]]'    => $user->email,
                    '[[password]]'      => $request->password,
                    'links'             => array(
                        '[[login_link]]' => array(
                            'url'   => route(AdminServiceProvider::BACKEND_LOGIN_ROUTE),
                            'title' => 'Click Here To Login'
                        )
                    )
                ));

                Mail::to($user->email)
                    ->send(new MayaMail($emailSubject, $emailBody));
            }

            return redirect()->route(AdminServiceProvider::USER_LIST_ROUTE)
                ->with([
                    'status' => TRUE,
                    'message' => AdminServiceProvider::USER_CREATE_OK_MSG
                ]);
        }

        return redirect()->route(AdminServiceProvider::USER_LIST_ROUTE)
            ->with([
                'status' => FALSE,
                'message' => AdminServiceProvider::USER_CREATE_FAILED_MSG
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
            return redirect()->route(AdminServiceProvider::USER_LIST_ROUTE)
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
                ]);
        }

        $user = $this->userRepository->get($id);
        if (!$user) {
            return redirect()->route(AdminServiceProvider::USER_LIST_ROUTE)
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
                ]);
        }

        $roles = $this->userRoleRepository->list()
            ->where('deleted_at', NULL)
            ->where('status', AdminServiceProvider::STATUS_ACTIVE)
            ->orderBy("name", "ASC")
            ->get();

        return view('admin.user.edit')
            ->with([
                'title' => 'Edit User',
                'modal_description' => $this->modal_description,
                'modal_title' => $this->modal_edit_title,
                'roles' => $roles,
                'cur_role' => isset($user->roles->pluck('name')[0]) ? $user->roles->pluck('name')[0] : '',
                'user' => $user
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $id = AdminServiceProvider::getAuthUser()->id;
        if (empty($id)) {
            return redirect()->route(AdminServiceProvider::BACKEND_DASHBOARD_ROUTE)
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
                ]);
        }

        $user = $this->userRepository->get($id);
        if (!$user) {
            return redirect()->route(AdminServiceProvider::BACKEND_DASHBOARD_ROUTE)
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
                ]);
        }

        $roles = $this->userRoleRepository->list()
            ->where('deleted_at', NULL)
            ->where('status', AdminServiceProvider::STATUS_ACTIVE)
            ->orderBy("name", "ASC")
            ->get();

        return view('admin.user.edit_profile')
            ->with([
                'title' => 'User Profile',
                'modal_description' => $this->modal_description,
                'modal_title' => $this->modal_edit_title,
                'roles' => $roles,
                'cur_role' => isset($user->roles->pluck('name')[0]) ? $user->roles->pluck('name')[0] : '',
                'user' => $user
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'user_role' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->where(function ($query) use ($request) {
                return $query->where('id', '!=', $request->user_id);
            })]
        ];

        if (!empty($request->password) && !empty($request->confirmed)) {
            $rules['password'] = ['required', 'string', 'min:8', 'same:confirmed'];
        }

        $id = AdminServiceProvider::getAuthUser()->id;
        $USER_EDIT = AdminServiceProvider::USER_EDIT_ROUTE;
        if ($request->user_id == $id) {
            $USER_EDIT = AdminServiceProvider::USER_PROFILE_EDIT_ROUTE;
            unset($rules['user_role']);
        }

        $validator = Validator::make(
            $request->all(),
            $rules,
            $this->messages()
        );

        if ($validator->fails()) {

            return redirect()->route($USER_EDIT, ['id' => $request->user_id])
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::USER_UPDATE_FAILED_MSG
                ])
                ->withErrors($validator)
                ->withInput();
        }

        $userID = $this->userRepository->update($request);
        if (!$userID) {
            return redirect()->route($USER_EDIT, ['id' => $request->user_id])
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::USER_UPDATE_FAILED_MSG
                ]);
        }
        $role_update = $this->userRepository->update_role($userID, $request->user_role);

        if (!$role_update) {
            return redirect()->route($USER_EDIT, ['id' => $request->user_id])
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::USER_UPDATE_FAILED_MSG
                ]);
        }
        return redirect()->route($USER_EDIT, ['id' => $request->user_id])
            ->with([
                'status' => TRUE,
                'message' => AdminServiceProvider::USER_UPDATE_OK_MSG
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
        if (empty($request->u_id)) {
            return [
                'status' => FALSE,
                'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
            ];
        }

        try {
            $deleted = $this->userRepository->destroy($request);
            if ($deleted) {
                return [
                    'status' => TRUE,
                    'message' => (!$request->u_id_status) ? AdminServiceProvider::USER_DELETE_SUCSESS_MSG : AdminServiceProvider::USER_ENBALE_SUCSESS_MSG
                ];
            }
        } catch (\Exception $e) {

            if ($e->getCode() == "23000") {
                return [
                    'status' => FALSE,
                    'message' => AdminServiceProvider::USER_DELETE_USED_MSG
                ];
            }

            return [
                'status' => FALSE,
                'message' => AdminServiceProvider::USER_DELETE_FAILED_MSG
            ];
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    private function messages()
    {
        return [
            'user_role.required' => 'The User Role is required.',
            'user_name.required' => 'The User Name is required.',
            'first_name.required' => 'The First Name is required.',
            'last_name.required' => 'The Last Name is required.',
            'email.required' => 'The Email is required.',
            'email.unique' => 'The Email has already been taken.'

        ];
    }
}
