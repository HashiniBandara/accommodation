<?php

namespace App\Http\Controllers\Admin\Accommodation;

use App\Http\Controllers\Controller;
use App\Mail\MayaMail;
use App\Providers\AdminServiceProvider;
use App\Providers\CommonServiceProvider;
use App\Repositories\SettingsRepository;
use App\Repositories\AccommodationDetailRepository;
use App\Repositories\UserRoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AccommodationDetailController extends Controller
{
    protected $search_columns = ["id", "accommodation_detail", "status"];

    private $accommodationDetailRepository;

    //private $accommodation_detailRoleRepository;

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
        AccommodationDetailRepository $accommodationDetailRepository,
        // UserRoleRepository $accommodation_detailRoleRepository,
        SettingsRepository $settingsRepository
    ) {
        $this->accommodationDetailRepository = $accommodationDetailRepository;
        //$this->userRoleRepository = $accommodation_detailRoleRepository;
        $this->settingsRepository = $settingsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $accommodation_types = $this->accommodationDetailRepository->index() //accommodation_detail
            //->where('deleted_at', NULL)
            //->where('status', AdminServiceProvider::STATUS_ACTIVE)
            //->where('id')
            ->orderBy("id", "ASC")
            ->get();
        return view('admin.accommodation.accommodation_detail')
            ->with([
                'title' => 'Create New Accommodation Details',
                'modal_description' => $this->modal_description,
                'modal_title' => $this->modal_status_title,
                'accommodation_types' => $accommodation_types
                //'modal_delete_route' => AdminServiceProvider::USER_DELETE_ROUTE
            ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function accommodation_detail_index() //accommodation_detail_index
    {

        // DB::table('accommodation_types')
        // ->leftJoin('accommodation_details', 'accommodation_types.id', '=', 'accommodation_details.accommodation_type_id')
        // ->select("*")
        // ->get();

        $accommodation_details = $this->accommodationDetailRepository->accommodation_detail_list() //accommodation_detail
            //->where('deleted_at', NULL)
            //->where('status', AdminServiceProvider::STATUS_ACTIVE)
            ->orderBy("id", "ASC")
            ->get();

        return view('admin.accommodation.accommodation_detail_index')
            ->with([
                'title' => 'View All Accommodation Detail',
                'modal_description' => $this->modal_description,
                'modal_title' => $this->modal_add_title,
                'accommodation_details' => $accommodation_details
            ]);
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function accommodation_detail_list(Request $request)
    {

        $data_list = [];
        $data_list['draw'] = intval($request->draw);
        $data_list['recordsTotal'] = $this->accommodationDetailRepository->rows_count();

        $accommodation_details = $this->accommodationDetailRepository->accommodation_detail_list()
            //->where('id')
            ->skip($request->start)
            ->take($request->length)
            ->where(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    foreach ($this->search_columns as $col) {
                        $query->orWhere($col, 'like', '%' . $request->search['value'] . '%');
                    }
                }
            })
            //->orderBy($this->search_columns[$request->order['0']['column']], $request->order[0]['dir'])
            ->get();

        if (empty($request->search['value'])) {
            $data_list['recordsFiltered'] = $this->accommodationDetailRepository->rows_count();
        } else {
            $data_list['recordsFiltered'] = count($accommodation_details);
        }

        if (!empty($accommodation_details)) {
            $accommodation_detail_list = [];
            foreach ($accommodation_details as $key => $accommodation_detail) {
                $actions = '';
                if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::ACCOMMODATION_DETAIL_LIST_EDIT_ROUTE)) {
                    $actions = $actions . '<a href="' . route(AdminServiceProvider::ACCOMMODATION_DETAIL_LIST_EDIT_ROUTE, ['id' => $accommodation_detail->id]) . '" class="' . DT_BTN_CLASSES . ' btn-primary"><i class="fa fa-pen"></i></a>';
                }

                if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::ACCOMMODATION_DETAIL_LIST_DELETE_ROUTE)) {

                    $actions = $actions . '<button ' . (AdminServiceProvider::getAuthUser()->id == $accommodation_detail->id ? 'disabled' : '') . ' data-id="' . $accommodation_detail->id . '" type="button" class="' . DT_BTN_CLASSES . ' btn-danger delete-btn"><i class="fa fa-trash"></i></button>';
                }

                $accommodation_detail_list[] = [
                    ($accommodation_detail->id),
                    $accommodation_detail->accommodation_type_id,
                    $accommodation_detail->title,
                    $accommodation_detail->banner,
                    $accommodation_detail->description,
                    $accommodation_detail->gallery,
                    CommonServiceProvider::getStatus($accommodation_detail->status),
                    $actions
                ];
            }
            $data_list['data'] = $accommodation_detail_list;
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
            'accommodation_type_id' => ['required', 'integer', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'banner' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'gallery' => ['required', 'string', 'max:255'],

        ], $this->messages());

        if ($validator->fails()) {
            return redirect()->route(AdminServiceProvider::ACCOMMODATION_DETAILS_CREATE_ROUTE)
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::VALIDATION_FAILED_MSG
                ])
                ->withErrors($validator)
                ->withInput();
        }

        //dd($request);

        $accommodation_detail_id = $this->accommodationDetailRepository->store($request);
        if ($accommodation_detail_id) {
            //$accommodation_detail = $this->AccommodationDetailRepository->get($accommodation_detailID);
            return redirect()->route(AdminServiceProvider::ACCOMMODATION_DETAILS_LIST_VIEW_ROUTE) //accommodation_detail_LIST_ROUTE
                ->with([
                    'status' => TRUE,
                    'message' => AdminServiceProvider::ACCOMMODATION_DETAIL_CREATE_OK_MSG
                ]);
        }

        return redirect()->route(AdminServiceProvider::ACCOMMODATION_DETAILS_LIST_VIEW_ROUTE)
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
            return redirect()->route(AdminServiceProvider::ACCOMMODATION_DETAILS_CREATE_ROUTE)
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
                ]);
        }

        $accommodation_detail = $this->accommodationDetailRepository->get($id);
        if (!$accommodation_detail) {
            return redirect()->route(AdminServiceProvider::ACCOMMODATION_DETAILS_CREATE_ROUTE)
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
                ]);
        }

        $accommodation_details = $this->accommodationDetailRepository->accommodation_detail_list()
            //->where('deleted_at', NULL)
            //->where('status', AdminServiceProvider::STATUS_ACTIVE)
            ->orderBy("id", "ASC")
            ->get();

        return view('admin.accommodation.accommodation_detail_edit')
            ->with([
                'title' => 'Edit Accommodation Details',
                'modal_description' => $this->modal_description,
                'modal_title' => $this->modal_edit_title,
                'accommodation_details' => $accommodation_details,
                //'cur_role' => isset($accommodation_detail->accommodation_details->pluck('name')[0]) ? $accommodation_detail->accommodation_details->pluck('name')[0] : '',
                'accommodation_detail' => $accommodation_detail
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function profile()
    // {
    //     $id = AdminServiceProvider::getAuthUser()->id;
    //     if (empty($id)) {
    //         return redirect()->route(AdminServiceProvider::BACKEND_DASHBOARD_ROUTE)
    //             ->with([
    //                 'status' => FALSE,
    //                 'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
    //             ]);
    //     }

    //     $accommodation_detail = $this->AccommodationDetailRepository->get($id);
    //     if (!$accommodation_detail) {
    //         return redirect()->route(AdminServiceProvider::BACKEND_DASHBOARD_ROUTE)
    //             ->with([
    //                 'status' => FALSE,
    //                 'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
    //             ]);
    //     }

    //     $accommodation_details = $this->userRoleRepository->accommodation_detail_list()
    //         ->where('deleted_at', NULL)
    //         ->where('status', AdminServiceProvider::STATUS_ACTIVE)
    //         ->orderBy("name", "ASC")
    //         ->get();

    //     return view('admin.user.edit_profile')
    //         ->with([
    //             'title' => 'User Profile',
    //             'modal_description' => $this->modal_description,
    //             'modal_title' => $this->modal_edit_title,
    //             'accommodation_details' => $accommodation_details,
    //             'cur_role' => isset($accommodation_detail->accommodation_details->pluck('name')[0]) ? $accommodation_detail->accommodation_details->pluck('name')[0] : '',
    //             'user' => $accommodation_detail
    //         ]);
    // }

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
            'accommodation_type_id' => ['required', 'integer', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'banner' => ['required'], //'banner' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'gallery' => ['required'], //'gallery' => ['required', 'string', 'max:255'],

        ];


        $id = AdminServiceProvider::getAuthUser()->id;
        $accommodation_detail_EDIT = AdminServiceProvider::USER_EDIT_ROUTE;
        if ($request->accommodation_detail_id == $id) {
            $accommodation_detail_EDIT = AdminServiceProvider::USER_PROFILE_EDIT_ROUTE;
            unset($rules['user_role']);
        }

        $validator = Validator::make(
            $request->all(),
            $rules,
            $this->messages()
        );

        if ($validator->fails()) {

            return redirect()->route($accommodation_detail_EDIT, ['id' => $request->accommodation_detail_id])
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::ACCOMMODATION_DETAIL_UPDATE_FAILED_MSG
                ])
                ->withErrors($validator)
                ->withInput();
        }

        $accommodation_detailID = $this->accommodationDetailRepository->update($request);
        if (!$accommodation_detailID) {
            return redirect()->route($accommodation_detail_EDIT, ['id' => $request->accommodation_detail_id])
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::ACCOMMODATION_DETAIL_UPDATE_FAILED_MSG
                ]);
        }
        // $role_update = $this->AccommodationDetailRepository->update_role($accommodation_detailID, $request->user_role);

        // if (!$role_update) {
        //     return redirect()->route($accommodation_detail_EDIT, ['id' => $request->accommodation_detail_id])
        //         ->with([
        //             'status' => FALSE,
        //             'message' => AdminServiceProvider::USER_UPDATE_FAILED_MSG
        //         ]);
        // }
        return redirect()->route($accommodation_detail_EDIT, ['id' => $request->accommodation_detail_id])
            ->with([
                'status' => TRUE,
                'message' => AdminServiceProvider::ACCOMMODATION_DETAIL_UPDATE_OK_MSG
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
        if (empty($request->id)) {
            return [
                'status' => FALSE,
                'message' => AdminServiceProvider::NO_LONGER_EXISTS_MSG
            ];
        }

        try {
            $deleted = $this->accommodationDetailRepository->destroy($request);
            if ($deleted) {
                return [
                    'status' => TRUE,
                    'message' => (!$request->id_status) ? AdminServiceProvider::USER_DELETE_SUCSESS_MSG : AdminServiceProvider::USER_ENBALE_SUCSESS_MSG
                ];
            }
        } catch (\Exception $e) {

            if ($e->getCode() == "23000") {
                return [
                    'status' => FALSE,
                    'message' => AdminServiceProvider::ACCOMMODATION_DETAIL_DELETE_USED_MSG
                ];
            }

            return [
                'status' => FALSE,
                'message' => AdminServiceProvider::ACCOMMODATION_DETAIL_DELETE_FAILED_MSG
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
            'accommodation_type_id.required' => 'The accommodation type is required.',
            'title.required' => 'The title is required.',
            'banner.required' => 'The banner is required.',
            'description.required' => 'The description is required.',
            'gallery.required' => 'The gallery is required.',

        ];
    }
}
