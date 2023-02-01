<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Repositories\SettingsRepository;
use App\RoutePaths\Admin\SettingsRoutePath;

class PagesController extends Controller
{

    /**
     * @var SettingsRepository
     */
    private $settingsRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        SettingsRepository $settingsRepository
    ) {
        $this->settingsRepository = $settingsRepository;
    }

    /**
     * Home page settings
     *
     * @return \Illuminate\Http\Response
     */
    public function home_settings()
    {

        return view('admin.pages.home')
            ->with([
                'title'             => 'Home Page Settings',
                'module_key'        => config('settings.home_page_key'),
                'redirect_back'     => SettingsRoutePath::HOME_PAGE,
            ]);
    }
    
}
