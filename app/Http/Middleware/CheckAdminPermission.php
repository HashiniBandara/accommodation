<?php

namespace App\Http\Middleware;

use App\Model\User;
use App\Providers\AdminServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::guard(AdminServiceProvider::GUARD)->check()){

            if(\Request::route()->getName() == AdminServiceProvider::BACKEND_LOG_OUT_ROUTE){
                return $next($request);
            }

            if(\Request::route()->getName() == AdminServiceProvider::UPLOAD_IMAGE_ROUTE){
                return $next($request);
            }

            if(\Request::route()->getName() == AdminServiceProvider::USER_PROFILE_EDIT_ROUTE){
                return $next($request);
            }

            $user = Auth::guard(AdminServiceProvider::GUARD)->user();
            $log_user = User::find($user->id);
            if($log_user->is_super_admin == AdminServiceProvider::IS_SUPER_ADMIN){
                return $next($request);
            }
            $user_permissions = $log_user->getPermissionsViaRoles()->pluck('route_name')->toArray();
            $request_method = Str::lower(\Request::method()).'.'.\Request::route()->getName();

            if(\Request::route()->getName() == AdminServiceProvider::PERMISSION_REQUIRED_ROUTE){
                return $next($request);
            }
            if(\in_array($request_method , $user_permissions)){
                return $next($request);
            }else{
                if($request->ajax()){

                    return response()->json([
                        'draw' => 0,
                        'recordsTotal' => 0,
                        'recordsFiltered' => 0,
                        'data' => [],
                        'redirect' => TRUE,
                        'url' => \URL::to('/').'/'.AdminServiceProvider::PERMISSION_REQUIRED_URL,
                    ]);
                }
                return redirect()->route(AdminServiceProvider::PERMISSION_REQUIRED_ROUTE, ['key' => Str::random(60)])
                ->with([
                    'status' => FALSE,
                    'message' => AdminServiceProvider::NO_PERMISSION_MSG
                ]);
            }

        }
        return $next($request);
    }
}
