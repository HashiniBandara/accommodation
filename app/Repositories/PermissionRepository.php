<?php namespace App\Repositories;

use App\Model\RoleHasPermission;
use App\Providers\AdminServiceProvider;
use Spatie\Permission\Models\Permission;

class PermissionRepository
{
	/**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return Permission::select("*");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $now = now();
        $permission = Permission::find($id);
        $permission->deleted_at = $now;
        $permission->save();

        // update paranet permission
        $paranet_permissions = Permission::where('parent', $permission->id)->get();
        if(!empty($paranet_permissions)){
            foreach ($paranet_permissions as $paranet_permission) {
                $paranet_permission->deleted_at = $now;
                $paranet_permission->save();
            }
        }
        return $permission->id;
    }

    /**
     * Get the active count of records.
     *
     * @return int
     */
    public function rows_count()
    {
        $permissions = Permission::select('id')
        ->where('deleted_at', NULL)
        ->where('is_list' ,AdminServiceProvider::IS_LIST)
        ->count();
        return $permissions;
    }

    /**
     * update role permissions
     *
     * @param  array  $permission_ids
     * @return bool
     */
    public function givePermissionTo($permission_ids)
    {
        try {
            RoleHasPermission::insert($permission_ids);
            return TRUE;
        } catch(\Exception  $ex){
            return FALSE;
        }
    }

    /**
     * update role permissions
     *
     * @param  array  $permission_ids
     * @param  int  $role_id
     * @return bool
     */
    public function updatePermissionTo($permission_ids , $role_id)
    {
        try {
            RoleHasPermission::where('role_id', $role_id)->forceDelete();
            $update = $this->givePermissionTo($permission_ids);
            if(!$update){
                return FALSE;
            }
            return TRUE;
        } catch(\Exception  $ex){
            return FALSE;
        }
    }

    /**
     * getParanetPermissions
     *
     * @param  int  $permission_id
     * @return bool/Permission
     */
    public function getParanetPermissions($permission_id)
    {
        try {
            $parents = Permission::where([
                'parent' => $permission_id,
                'deleted_at' => NULL,
                'is_list' => !AdminServiceProvider::IS_LIST
            ])->get();
            return $parents;
        } catch(\Exception  $ex){
            return FALSE;
        }
    }

    /**
     * getPermissionRequiredRoute
     *
     * @return View
     */
    public function getPermissionRequiredRoute()
    {
        try {
            $route = Permission::where([
                'module' => AdminServiceProvider::PERMISSION_REQUIRED_MODULE,
                'route_name' => 'get.'.AdminServiceProvider::PERMISSION_REQUIRED_ROUTE,
                'deleted_at' => NULL,
                'is_list' => !AdminServiceProvider::IS_LIST
            ])->get()->first();
            return $route;
        } catch(\Exception  $ex){
            return FALSE;
        }
    }
}
