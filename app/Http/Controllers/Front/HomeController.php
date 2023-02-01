<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\SettingsRepository;

class HomeController extends Controller
{

    /** @var SettingsRepository */
    private $settingsRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        SettingsRepository $settingsRepository,
    ) {
        $this->settingsRepository = $settingsRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $pageData = $this->settingsRepository->getByModule(config('settings.home_page_key'));

        return view('front.home.home')
            ->with([
                'title'         => '',
                'pageData'      => $pageData,
            ]);
    }
}
