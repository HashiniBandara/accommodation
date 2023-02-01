<?php

namespace App\Repositories;

use App\Model\User;
use App\Providers\AdminServiceProvider;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return User::select("*");
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
            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->status = empty($request->user_status) ? STATUS_INACTIVE : STATUS_ACTIVE;
            $user->created_at = $now;
            $user->updated_at = $now;
            $user->save();
            return $user->id;
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
            $user = User::find($request->user_id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->profile_pic = empty($request->user_image) ? '' : $request->user_image;
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->status = empty($request->user_status) ? AdminServiceProvider::STATUS_INACTIVE : AdminServiceProvider::STATUS_ACTIVE;
            $user->save();
            return $user->id;
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
        $user = User::find($request->u_id);
        $roles = $user->roles->all();
        $role = count($roles)>0 ? $roles[0]:null;
        try {
            return User::destroy($request->u_id);
        } catch (\Exception  $ex) {
            $user->roles()->detach();
            $user->forgetCachedPermissions();
            $user->assignRole($role);
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
        $roles = User::select('id')->where('is_super_admin', 0)->count();
        return $roles;
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
            return User::find($id);
        } catch (\Exception  $ex) {
            return FALSE;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $user_id
     * @param  var  $role
     *
     * @return \Illuminate\Http\Response
     */
    public function update_role($user_id, $role)
    {
        try {
            $user = User::find($user_id);
            $user->roles()->detach();
            $user->forgetCachedPermissions() .
                $user->assignRole($role);
            return TRUE;
        } catch (\Exception  $ex) {
            return FALSE;
        }
    }
}
