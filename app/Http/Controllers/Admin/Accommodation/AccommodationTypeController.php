<?php

namespace App\Http\Controllers\Admin\Accommodation;

use App\Http\Controllers\Controller;
use App\Mail\MayaMail;
use App\Providers\AdminServiceProvider;
use App\Providers\CommonServiceProvider;
use App\Repositories\SettingsRepository;
use App\Repositories\AccommodationTypeRepository;
use App\Repositories\UserRoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AccommodationTypeController extends Controller
{
    protected $search_columns = ["id", "accommodation_type", "status"];

    private $accommodationTypeRepository;

    //private $accommodation_typeRoleRepository;

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
        AccommodationTypeRepository $accommodationTypeRepository,
        // UserRoleRepository $accommodation_typeRoleRepository,
        SettingsRepository $settingsRepository
    ) {
        $this->accommodationTypeRepository = $accommodationTypeRepository;
        //$this->userRoleRepository = $accommodation_typeRoleRepository;
        $this->settingsRepository = $settingsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.accommodation.accommodation_type')
            ->with([
                'title' => 'AccommodationTypes',
                'modal_description' => $this->modal_description,
                'modal_title' => $this->modal_status_title,
                //'modal_delete_route' => AdminServiceProvider::ACCOMMODATION_TYPE_DELETE_ROUTE
            ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function accommodation_type_index()
    {
        $accommodation_types = $this->accommodationTypeRepository->list() //accommodation_type
            //->where('deleted_at', NULL)
            // ->where('status', AdminServiceProvider::STATUS_ACTIVE)
            ->orderBy("accommodation_type", "ASC")
            ->get();

        return view('admin.accommodation.accommodation_type_index') //accommodation_type
            ->with([
                'title' => 'View All Accommodation Type',
                'modal_description' => $this->modal_description,
                'modal_title' => $this->modal_add_title,
                'accommodation_types' => $accommodation_types
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
        $data_list['recordsTotal'] = $this->accommodationTypeRepository->rows_count();

        $accommodation_types = $this->accommodationTypeRepository->list()
            //->where('accommodation_type', [0])
            ->skip($request->start)
            ->take($request->length)
            ->where(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    foreach ($this->search_columns as $col) {
                        $query->orWhere($col, 'like', '%' . $request->search['value'] . '%');
                    }
                }
            })
            ->orderBy($this->search_columns[$request->order['0']['column']], $request->order[0]['dir'])
            ->get();

        if (empty($request->search['value'])) {
            $data_list['recordsFiltered'] = $this->accommodationTypeRepository->rows_count();
        } else {
            $data_list['recordsFiltered'] = count($accommodation_types);
        }

        if (!empty($accommodation_types)) {
            $accommodation_type_list = [];
            foreach ($accommodation_types as $key => $accommodation_type) {
                $actions = '';
                if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::ACCOMMODATION_LIST_EDIT_ROUTE)) {
                    $actions = $actions . '<a href="' . route(AdminServiceProvider::ACCOMMODATION_LIST_EDIT_ROUTE, ['id' => $accommodation_type->id]) . '" class="' . DT_BTN_CLASSES . ' btn-primary"><i class="fa fa-pen"></i></a>';
                }

                if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::ACCOMMODATION_LIST_DELETE_ROUTE)) {

                    $actions = $actions . '<button ' . (AdminServiceProvider::getAuthUser()->id == $accommodation_type->id ? 'disabled' : '') . ' data-id="' . $accommodation_type->id . '" type="button" class="' . DT_BTN_CLASSES . ' btn-danger delete-btn"><i class="fa fa-trash"></i></button>';
                }

                $accommodation_type_list[] = [
                    ($accommodation_type->id),
                    $accommodation_type->accommodation_type,
                    CommonServiceProvider::getStatus($accommodation_type->status),
                    $actions
                ];
            }
            $data_list['data'] = $accommodation_type_list;
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
            'accommodation_type' => ['required', 'string', 'max:255'],

        ], $this->messages());

        if ($validator->fails()) {
            return redirect()->route(AdminServiceProvider::ACCOMMODATION_TYPE_CREATE_ROUTE)
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::VALIDATION_FAILED_MSG
                ])
                ->withErrors($validator)
                ->withInput();
        }

        //dd($request);

        $accommodation_type_id = $this->accommodationTypeRepository->store($request);
        if ($accommodation_type_id) {
            return redirect()->route(AdminServiceProvider::ACCOMMODATION_LIST_VIEW_ROUTE)
                ->with([
                    'status' => TRUE,
                    'message' => AdminServiceProvider::ACCOMMODATION_TYPE_CREATE_OK_MSG
                ]);
        }

        return redirect()->route(AdminServiceProvider::ACCOMMODATION_LIST_VIEW_ROUTE)
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
            return redirect()->route(AdminServiceProvider::ACCOMMODATION_TYPE_CREATE_ROUTE)
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
                ]);
        }

        $accommodation_type = $this->accommodationTypeRepository->get($id);
        if (!$accommodation_type) {
            return redirect()->route(AdminServiceProvider::ACCOMMODATION_TYPE_CREATE_ROUTE)
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
                ]);
        }

        $accommodation_types = $this->accommodationTypeRepository->list()
            //->where('deleted_at', NULL)
            ->where('status', AdminServiceProvider::STATUS_ACTIVE)
            ->orderBy("accommodation_type", "ASC")
            ->get();

        return view('admin.accommodation.accommodation_type_edit')
            ->with([
                'title' => 'Edit Accommodation Type',
                'modal_description' => $this->modal_description,
                'modal_title' => $this->modal_edit_title,
                'accommodation_types' => $accommodation_types,
                'user' => $accommodation_type
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
             'accommodation_type' => ['required', 'string', 'max:255'],

         ];

         $accommodation_type_EDIT = AdminServiceProvider::ACCOMMODATION_LIST_VIEW_ROUTE;

         $validator = Validator::make(
             $request->all(),
             $rules,
             $this->messages()
         );

         if ($validator->fails()) {

             return redirect()->route($accommodation_type_EDIT, ['id' => $request->user_id])
                 ->with([
                     'status' => FALSE,
                     'message' => AdminServiceProvider::ACCOMMODATION_TYPE_UPDATE_FAILED_MSG
                 ])
                 ->withErrors($validator)
                 ->withInput();
         }

         $accommodation_typeID = $this->accommodationTypeRepository->update($request);
         if (!$accommodation_typeID) {
             return redirect()->route($accommodation_type_EDIT, ['id' => $request->user_id])
                 ->with([
                     'status' => FALSE,
                     'message' => AdminServiceProvider::ACCOMMODATION_TYPE_UPDATE_FAILED_MSG
                 ]);
         }

         return redirect()->route($accommodation_type_EDIT, ['id' => $request->user_id])
             ->with([
                 'status' => TRUE,
                 'message' => AdminServiceProvider::ACCOMMODATION_TYPE_UPDATE_OK_MSG
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
        if (empty($request->accommodation_type_id)) {
            return [
                'status' => FALSE,
                'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
            ];
        }

        try {
            $deleted = $this->accommodationTypeRepository->destroy($request);
            if ($deleted) {
                return [
                    'status' => TRUE,
                    'message' => (!$request->accommodation_type_id_status) ? AdminServiceProvider::USER_DELETE_SUCSESS_MSG : AdminServiceProvider::USER_ENBALE_SUCSESS_MSG
                ];
            }
        } catch (\Exception $e) {

            if ($e->getCode() == "23000") {
                return [
                    'status' => FALSE,
                    'message' => AdminServiceProvider::ACCOMMODATION_TYPE_DELETE_USED_MSG
                ];
            }

            return [
                'status' => FALSE,
                'message' => AdminServiceProvider::ACCOMMODATION_TYPE_DELETE_FAILED_MSG
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
            'accommodation_type.required' => 'The User Role is required.',
            // 'user_name.required' => 'The User Name is required.',
            // 'first_name.required' => 'The First Name is required.',
            // 'last_name.required' => 'The Last Name is required.',
            // 'email.required' => 'The Email is required.',
            // 'email.unique' => 'The Email has already been taken.'

        ];
    }
}
