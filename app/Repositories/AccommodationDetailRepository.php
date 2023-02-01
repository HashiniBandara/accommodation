<?php

namespace App\Repositories;

use App\Model\Accommodation_detail;
use App\Model\Accommodation_type;
use App\Providers\AdminServiceProvider;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccommodationDetailRepository
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accommodation_detail_list()
    {

        DB::table('accommodation_types')
            ->leftJoin('accommodation_details', 'accommodation_types.id', '=', 'accommodation_details.accommodation_type_id')
            ->select("*")
            ->get();

        return Accommodation_detail::select("*");

    }

    public function index()
    {
        return Accommodation_type::select("*");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $now = now();
        try {
            $accommodation_detail = new accommodation_detail;
            $accommodation_detail->accommodation_type_id = $request->accommodation_type_id;
            $accommodation_detail->title = $request->title;

            // $banner = array();
            // if ($files = $request->file('banner')) {
            //     foreach ($files as $file) {
            //         $banner_name = time();
            //         $ext = strtolower($file->getClientOriginalExtension());
            //         $banner_full_name = $banner_name . '.' . $ext;
            //         $upload_path = 'accommodationimages/';
            //         $banner_url = $upload_path . $banner_full_name;
            //         $file->move($upload_path, $banner_full_name);
            //         $banner[] = $banner_url;
            //     }
            // }
            // $accommodation_detail->banner = implode('|', $banner);

            $accommodation_detail->banner = $request->banner;
            $accommodation_detail->description = $request->description;

            // $gallery = array();
            // if ($files = $request->file('gallery')) {
            //     foreach ($files as $file) {
            //         $gallery_name = time();
            //         $ext = strtolower($file->getClientOriginalExtension());
            //         $gallery_full_name = $gallery_name . '.' . $ext;
            //         $upload_path = 'accommodationimages/';
            //         $gallery_url = $upload_path . $gallery_full_name;
            //         $file->move($upload_path, $gallery_full_name);
            //         $gallery[] = $gallery_url;
            //     }
            // }
            // $accommodation_detail->gallery = implode('|', $gallery);

            $accommodation_detail->gallery = $request->gallery;
            $accommodation_detail->status = empty($request->accommodation_detail_status) ? STATUS_INACTIVE : STATUS_ACTIVE;
            $accommodation_detail->created_at = $now;
            $accommodation_detail->updated_at = $now;
            $accommodation_detail->save();
            return $accommodation_detail->id;
        } catch (\Exception  $ex) {
            return $ex;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update($request)
    {
        $now = now();
        try {
            $accommodation_detail = accommodation_detail::find($request->accommodation_detail_id);
            $accommodation_detail->accommodation_type_id = $request->accommodation_type_id;
            $accommodation_detail->title = $request->title;
            $accommodation_detail->banner = $request->banner;
            $accommodation_detail->description = $request->description;
            $accommodation_detail->gallery = $request->gallery;
            $accommodation_detail->status = empty($request->accommodation_detail_status) ? AdminServiceProvider::STATUS_INACTIVE : AdminServiceProvider::STATUS_ACTIVE;
            $accommodation_detail->save();
            return $accommodation_detail->id;
        } catch (\Exception  $ex) {
            return FALSE;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     * @throws \Exception
     */
    public function destroy($request)
    {
        Accommodation_detail::find($request->id);
        try {
            return Accommodation_detail::destroy($request->id);
        } catch (\Exception  $ex) {
            throw $ex;
        }
    }

    /**
     * Get the active count of records.
     *
     * @return int
     */
    public function rows_count()
    {
        $accommodation_details = accommodation_detail::select('id')->count();
        return $accommodation_details;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        try {
            return accommodation_detail::find($id);
        } catch (\Exception  $ex) {
            return FALSE;
        }
    }
}
