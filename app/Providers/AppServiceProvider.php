<?php

namespace App\Providers;

use App\Repositories\PermissionRepository;
use App\Repositories\SettingsRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;
use Exception;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(PermissionRepository::class, new PermissionRepository());
        $this->app->instance(UserRoleRepository::class, new UserRoleRepository());
        $this->app->instance(UserRepository::class, new UserRepository());
        $this->app->instance(SettingsRepository::class, new SettingsRepository());
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            View::share('themeSettingsKey', config('settings.theme_key'));
            View::share('siteTitle', getSettingValue(config('settings.theme_key'), 'site_title'));
        } catch (Exception $ex) {
        }

        Paginator::useBootstrap();
    }
}
