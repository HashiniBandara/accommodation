<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Order\Order;
use App\Providers\AdminServiceProvider;
use App\Providers\OrderServiceProvider;
use Illuminate\Http\Request;
use Str;

class DashboardController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.dashboard.main')->with([
            'title' => 'Dashboard',
        ]);
    }

    /**
     * Show the application permission.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function permission(Request $request)
    {
        return view('admin.dashboard.permission')->with([
            'status' => FALSE,
            'message' => AdminServiceProvider::NO_PERMISSION_MSG
        ]);
    }
}
