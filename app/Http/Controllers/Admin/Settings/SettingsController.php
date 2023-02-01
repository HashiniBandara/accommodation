<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Messages\Admin\SettingsMessage;
use App\Repositories\SettingsRepository;
use App\RoutePaths\Admin\SettingsRoutePath;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected $search_columns = ["id", "module", "key", "value"];

    private $modal_description = "Are you sure you wish to continue ?";

    private $modal_edit_title = "Update settings";

    private $settingsRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Factory
     */
    public function theme_settings()
    {
        return view('admin.settings.theme-settings')
            ->with([
                'title' => 'Theme Settings',
                'modal_description' => $this->modal_description,
                'modal_title' => $this->modal_edit_title,
                'module_key' => config('settings.theme_key'),
                'redirect_back' => SettingsRoutePath::THEME
            ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function general_email_settings()
    {
        return view('admin.settings.email-settings')
            ->with([
                'title' => 'Email Settings',
                'modal_description' => $this->modal_description,
                'modal_title' => $this->modal_edit_title,
                'module_key' => config('settings.email_key'),
                'redirect_back' => SettingsRoutePath::EMAIL
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate(Request $request)
    {
        $allSettings = $request->all();

        if (!empty($allSettings)) {
            try {
                foreach ($allSettings as $settingsKey => $settingValue) {
                    $settings = substr($settingsKey, 0, 3);
                    if ($settings == config('settings.separator')) {
                        $settingKey = preg_replace('/' . config('settings.separator') . '/', "", $settingsKey, 1);

                        if (is_array($allSettings[$settingsKey])) {
                            $settingValue = json_encode($settingValue);
                        }

                        $this->settingsRepository->setValue($allSettings['module_key'], $settingKey, $settingValue);
                    }
                }

                if ($request->ajax()) {
                    return response()->json(array(
                        'status' => true
                    ));
                } else {
                    return redirect()->route($allSettings['redirect_back'])
                        ->with([
                            'status' => TRUE,
                            'message' => SettingsMessage::CREATE_SUCCESS
                        ]);
                }
            } catch (\Exception  $ex) {
                if ($request->ajax()) {
                    return response()->json(array(
                        'status' => false,
                        'message' => $ex->getMessage()
                    ));
                } else {
                    return redirect()->route($allSettings['redirect_back'])
                    ->with([
                        'status' => false,
                        'message' => MSG_ERROR_OCCURED
                    ])->withInput();
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $module
     * @return array
     */
    private function get($module)
    {
        $ar_settings = [];
        try {
            $settings = $this->settingsRepository->getByModule($module);

            if (!empty($settings)) {
                foreach ($settings as $settings) {
                    $ar_settings[$settings->key] = $settings->value;
                }
            }
            return $ar_settings;
        } catch (\Exception  $ex) {
            return [];
        }
    }
}
