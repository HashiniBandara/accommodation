<?php

namespace App\Repositories;

use App\Providers\AdminServiceProvider;
use Spatie\Permission\Models\Role;

class UserRoleRepository extends CommonRepository
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return Role::select("*");
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
            $role = new Role;
            $role->name = $request->role_name;
            $role->guard_name = AdminServiceProvider::GUARD;
            $role->status = STATUS_ACTIVE;
            $role->created_at = $now;
            $role->updated_at = $now;
            $role->save();
            return $role->id;
        } catch (\Exception  $ex) {
            return FALSE;
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
            $role = Role::find($request->role_id);
            $role->name = $request->role_name;
            $role->status = empty($request->role_status) ? STATUS_INACTIVE : STATUS_ACTIVE;
            $role->updated_at = $now;
            $role->save();
            return $role->id;
        } catch (\Exception  $ex) {
            return FALSE;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return int
     */
    public function destroy($request)
    {
        try {
            return Role::destroy($request->r_id);
        } catch (\Exception  $ex) {
            return FALSE;
        }
    }

    /**
     * Get the active count of records.
     *
     * @return int
     */
    public function rows_count()
    {
        $roles = Role::select('id')
            ->where('deleted_at', NULL)
            ->count();
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
            return Role::find($id);
        } catch (\Exception  $ex) {
            return FALSE;
        }
    }

    protected function getModelName()
    {
        return Role::class;
    }
}
