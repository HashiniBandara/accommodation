<?php

namespace App\Repositories;

use App\Model\Accommodation_detail;
use App\Model\Accommodation_type;
use App\Providers\AdminServiceProvider;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Hash;

class AccommodationTypeRepository
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list()
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
            $accommodation_type = new Accommodation_type;
            $accommodation_type->accommodation_type = $request->accommodation_type;
            $accommodation_type->status = empty($request->accommodation_type_status) ? STATUS_INACTIVE : STATUS_ACTIVE;
            $accommodation_type->created_at = $now;
            $accommodation_type->updated_at = $now;
            $accommodation_type->save();
            return $accommodation_type->id;
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
             $accommodation_type = Accommodation_type::find($request->user_id);
             $accommodation_type->accommodation_type = $request->accommodation_type;
             $accommodation_type->status = empty($request->accommodation_type_status) ? AdminServiceProvider::STATUS_INACTIVE : AdminServiceProvider::STATUS_ACTIVE;
             $accommodation_type->save();
             return $accommodation_type->id;
         } catch (\Exception  $ex) {
             return FALSE;
         }
     }

    // public function update($request)
    // {
    //     $now = now();
    //     try {
    //         $accommodation_type = Accommodation_type::find($request->user_id);
    //         $accommodation_type->accommodation_type = $request->accommodation_type;
    //         $accommodation_type->status = empty($request->accommodation_type_status) ? AdminServiceProvider::STATUS_INACTIVE : AdminServiceProvider::STATUS_ACTIVE;
    //         $accommodation_type->save();
    //         return $accommodation_type->id;
    //     } catch (\Exception  $ex) {
    //         return FALSE;
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     * @throws \Exception
     */
    public function destroy($request)
    {
        Accommodation_type::find($request->accommodation_type_id);
        try {
            return Accommodation_type::destroy($request->accommodation_type_id);
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
        $accommodation_types = Accommodation_type::select('id')->count();
        return $accommodation_types;
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
            return Accommodation_type::find($id);
        } catch (\Exception  $ex) {
            return FALSE;
        }
    }
}
