<?php

use App\Repositories\SettingsRepository;
use Illuminate\Support\Facades\App;

defined('BACKEND_PREFIX') || define('BACKEND_PREFIX', 'admin'); // Admin backend prefix

// Status List
defined('STATUS_PENDING') || define('STATUS_PENDING', 0);
defined('STATUS_ACTIVE') || define('STATUS_ACTIVE', 1);
defined('STATUS_INACTIVE') || define('STATUS_INACTIVE', 2);

defined('TIMESTAMP_FORMAT') || define('TIMESTAMP_FORMAT', 'Y-m-d H:i:s');

defined('DT_BTN_CLASSES') || define('DT_BTN_CLASSES', 'btn btn-icon btn-sm');

defined('EMAIL_BTN_CLASSES') || define('EMAIL_BTN_CLASSES', 'button button-primary');

defined('MSG_ERROR_OCCURED') || define('MSG_ERROR_OCCURED', 'Error occured while processing request. Please try again.');

defined('VALIDATION_FAILED_MSG') || define('VALIDATION_FAILED_MSG', 'Validation failed. Please fill all required fields.');

defined('DB_RECORD_USED_E_CODE') || define('DB_RECORD_USED_E_CODE', '23000');

defined('ITEMS_PER_PAGE') || define('ITEMS_PER_PAGE', 9);

if (!function_exists('assets_path')) {
    /**
     * get local asset url
     * @return string
     */
    function assets_path($path)
    {
        return config('app.url') . '/public' . '/' . $path;
    }
}

if (!function_exists('getFailedResponseArray')) {
    /**
     * get failed response array
     * @return array
     */
    function getFailedResponseArray($message)
    {
        return [
            'status' => FALSE,
            'message' => $message
        ];
    }
}

if (!function_exists('getSuccessResponseArray')) {
    /**
     * get success response array
     * @return array
     */
    function getSuccessResponseArray($message)
    {
        return [
            'status' => TRUE,
            'message' => $message
        ];
    }
}

if (!function_exists('dashesToCamelCase')) {
    function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
    {
        $str = str_replace('_', ' ', ucwords($string, '_'));
        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }
        return ucwords($str);
    }
}

if (!function_exists('getSettingValue')) {
    function getSettingValue($module, $key)
    {
        $settingsRepository = App::make(SettingsRepository::class);
        return $settingsRepository->getValue($module, $key);
    }
}

// Less compiler
function compileCSS()
{
    if (getSettingValue(config('settings.theme_key'), 'compile_assets')) {

        $less = new lessc;

        $less->compileFile(public_path("assets/front/css/less/master.less"), public_path("assets/front/css/master.css"));

        minifyCSS();

        minifyJS();
    }
}

use MatthiasMullie\Minify;

function minifyCSS()
{

    $master = public_path('assets/front/css/master.css');
    $minifier = new Minify\CSS($master);

    $minifier->add('assets/front/css/owl.carousel.min.css');

    $minifier->add('assets/front/css/owl.theme.default.min.css');

    $minifier->add('assets/front/mmenu/mmenu.css');

    // save minified file to disk
    $minifiedPath = public_path('assets/front/css/master.min.css');
    $minifier->minify($minifiedPath);
}

function minifyJS()
{

    $bootstrap = public_path('assets/front/js/bootstrap.bundle.min.js');
    $minifier = new Minify\JS($bootstrap);

    // we can even add another file, they'll then be
    // joined in 1 output file

    $minifier->add(public_path('assets/front/js/owl.carousel.min.js'));

    $minifier->add(public_path('assets/front/mmenu/mmenu.js'));
    
    $minifier->add(public_path('assets/front/mmenu/mmenu.js'));

    $custom = public_path('assets/front/js/custom.js');
    $minifier->add($custom);

    // save minified file to disk
    $minifiedPath = public_path('assets/front/js/custom-combined.min.js');
    $minifier->minify($minifiedPath);
}

/**
 * Check is image is small
 *
 * @param       string      $imagePath               Image path
 * @return      bool       
 */
function isSmallImage($imagePath = null)
{

    if (!$imagePath) {
        return false;
    }

    $filePath = str_replace(getenv('APP_URL'), '', $imagePath);
    try {
        $data = getimagesize($filePath);
        if (!empty($data[0]) && $data[0] < 50) {
            return true;
        }
    } catch (\Throwable $th) {
    }

    return false;
}
