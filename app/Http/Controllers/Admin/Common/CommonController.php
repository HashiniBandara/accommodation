<?php

namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use App\Providers\CommonServiceProvider;
use Illuminate\Http\Request;

class CommonController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeImage(Request $request)
    {
        $destinationPath = $request->get("destinationPath");

        $res_upload = CommonServiceProvider::storeImage($request , $destinationPath ,"file");
        return \Response::json($res_upload, 200);
    }


}
