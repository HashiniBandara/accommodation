<?php

namespace App\Console\Commands;

use App\Providers\AdminServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class SyncPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:permissions {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all back end web routes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * sync permissions
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');
        if($action == "create"){
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('role_has_permissions')->truncate();
            DB::table('permissions')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // read all routes
        $getRoutes = app('router')->getRoutes();
        $routes_collect = collect($getRoutes);

        if(!empty($routes_collect)){
            foreach ($routes_collect as $route_map) {
                $action = collect($route_map->action);
                $methods = collect($route_map->methods);

                if(\in_array(AdminServiceProvider::MIDDLEWARE_NAME, $action->get('middleware')) &&
                    !empty($action->get("module")) && empty($action->get("parent"))){
                    // check permission already exists
                    $find_permission = Permission::where(
                        [
                            "module" => $action->get("module"),
                            "parent" => 0,
                            "route_name" => Str::lower($methods[0]).'.'.$action->get("as"),
                            "guard_name" => AdminServiceProvider::MIDDLEWARE_NAME,
                        ]
                    )->get()->first();

                    if(empty($find_permission)){
                        $permission = new Permission;
                        $permission->is_list = $action->get("is_list");
                        $permission->parent = 0;
                        $permission->module = $action->get("module");
                        $permission->route_name = Str::lower($methods[0]).'.'.$action->get("as");
                        $permission->real_route_name = $action->get("as");
                        $permission->guard_name = AdminServiceProvider::MIDDLEWARE_NAME;
                        $permission->name = $action->get("show_as");
                        try{
                            $permission->save();  // insert new permission
                        }catch(\Illuminate\Database\QueryException $ex){
                            $this->error("insert error - " . $ex->getMessage());
                            continue;
                        }
                    }else{
                        $find_permission->is_list = $action->get("is_list");
                        $find_permission->parent = 0;
                        $find_permission->module = $action->get("module");
                        $find_permission->route_name = Str::lower($methods[0]).'.'.$action->get("as");
                        $find_permission->real_route_name = $action->get("as");
                        $find_permission->guard_name = AdminServiceProvider::MIDDLEWARE_NAME;
                        $find_permission->name = $action->get("show_as");

                        try{
                            $find_permission->update();  // update permission
                        }catch(\Illuminate\Database\QueryException $ex){
                            $this->error("update error - " . $ex->getMessage());
                            continue;
                        }
                    }
                }
            }
            $this->syncParentRoutes();
            $this->info("Permissions Synced.");
        }else{
            $this->info("No routes found.");
        }
    }

    /**
     * Execute the console command.
     * syncParentRoutes
     * @return mixed
     */
    private function syncParentRoutes()
    {
        // read all routes
        $getRoutes = app('router')->getRoutes();
        $routes_collect = collect($getRoutes);

        if(!empty($routes_collect)){
            foreach ($routes_collect as $route_map) {
                $action = collect($route_map->action);
                $methods = collect($route_map->methods);

                if(\in_array(AdminServiceProvider::MIDDLEWARE_NAME, $action->get('middleware')) &&
                    !empty($action->get("module")) && !empty($action->get("parent"))){
                    // check permission already exists
                    $find_permission_par = Permission::where(
                        [
                            "module" => $action->get("module"),
                            "route_name" => $action->get("parent"),
                            "guard_name" => AdminServiceProvider::MIDDLEWARE_NAME
                        ]
                    )->get()->first();

                    if(empty($find_permission_par)){
                        continue;
                    }

                    $find_permission = Permission::where(
                        [
                            "module" => $action->get("module"),
                            "parent" => $find_permission_par->id,
                            "route_name" => Str::lower($methods[0]).'.'.$action->get("as"),
                            "guard_name" => AdminServiceProvider::MIDDLEWARE_NAME,
                            "name" => $action->get("show_as")
                        ]
                    )->get()->first();

                    if(empty($find_permission)){
                        $permission = new Permission;
                        $permission->is_list = $action->get("is_list");
                        $permission->parent = $find_permission_par->id;
                        $permission->module = $action->get("module");
                        $permission->route_name = Str::lower($methods[0]).'.'.$action->get("as");
                        $permission->real_route_name = $action->get("as");
                        $permission->guard_name = AdminServiceProvider::MIDDLEWARE_NAME;
                        $permission->name = $action->get("show_as");
                        try{
                            $permission->save();  // insert new permission
                        }catch(\Illuminate\Database\QueryException $ex){
                            $this->error("insert error syncParentRoutes - " . $ex->getMessage());
                            continue;
                        }
                    }else{
                        $find_permission->is_list = $action->get("is_list");
                        $find_permission->parent = $find_permission_par->id;
                        $find_permission->module = $action->get("module");
                        $find_permission->route_name = Str::lower($methods[0]).'.'.$action->get("as");
                        $find_permission->real_route_name = $action->get("as");
                        $find_permission->guard_name = AdminServiceProvider::MIDDLEWARE_NAME;
                        $find_permission->name = $action->get("show_as");

                        try{
                            $find_permission->update();  // update permission
                        }catch(\Illuminate\Database\QueryException $ex){
                            $this->error("update error - syncParentRoutes " . $ex->getMessage());
                            continue;
                        }
                    }
                }
            }

        }
    }
}
