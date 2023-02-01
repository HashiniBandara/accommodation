<?php

namespace App\Providers;

use App\Repositories\SettingsRepository;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;


class CommonServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    public const NO_LONGER_EXISTS = 'This record no longer exists.';

    /**
     * Validation Error Message
     *
     * @var string
     */
    public const VALIDATION_FAILED_MSG = "Validation failed. Please fill all required fields.";

    /**
     * Error Occured Message
     *
     * @var string
     */
    public const ERROR_OCCURED_MSG = "Error occured while processing. Please try again.";

    /**
     * Currency Symbol
     *
     * @var string
     */
    public const CURRENCY = "LKR";

    public function boot(){
        $themeSettingsKey = config('settings.theme_key');
        View::share('siteTitle', getSettingValue($themeSettingsKey, 'site_title'));
    }

    /**
     * method may be used to store file contents on a disk.
     * You may also pass a PHP resource to the put method,
     *
     * @param \Illuminate\Http\Request  $request
     * @param  string  $destinationPath
     * @param  string  $field
     *
     * @return array
     */
    public static function storeImage($request, $destinationPath, $field)
    {
        $fls_env = config('filesystems.default');
        $ar_res = [
            "status" => FALSE,
            "full_path" => "",
        ];

        if ($request->hasFile($field)) {

            $imageReg = "/[\/.](gif|jpg|jpeg|tiff|png)$/i";
            try {
                $file = $request->file($field);
                $extension = $file->extension();
                $original_name = $file->getClientOriginalName();
                $original_name = str_replace("_", " ", $original_name);
                $original_name = preg_replace('/[^A-Za-z0-9\-]/', '', $original_name);
                $original_name = Str::kebab($original_name);
                $original_name = substr($original_name, 0, strlen($original_name) - strlen($extension) - 1);

                $settingsRepository = app()->get(SettingsRepository::class);
                $id = $settingsRepository->getValue("common", "file_id");
                if (empty($id)) {
                    $settingsRepository->setValue("common", "file_id", 1);
                    $id = 1;
                }

                $name = $original_name . '-' . $id . '.' . $extension;
                $filePath = $destinationPath . '/' . $name;
                Storage::disk($fls_env)->put($filePath, file_get_contents($file), 'public');
                $full_path = Storage::disk($fls_env)->url($filePath);

                $ar_res["status"] = TRUE;
                $ar_res["full_path"] = $full_path;
                $ar_res["file_name"] = pathinfo($full_path, PATHINFO_BASENAME);
                $ar_res["is_image"] = FALSE;
                if (preg_match($imageReg, $ar_res["file_name"])) {
                    $ar_res["is_image"] = TRUE;
                    $ar_res["small_image"] = isSmallImage($full_path);
                }
                $settingsRepository->setValue("common", "file_id", $id + 1);
                return $ar_res;
            } catch (\Exception $ex) {
                $ar_res["msg"] = $ex->getMessage();
                $ar_res["status"] = FALSE;
                return $ar_res;
            }
        }
        return $ar_res;
    }


    /**
     * method may be used to get file contents on a disk.
     * You may also pass a PHP resource to the get method,
     *
     * @param  string  $file_name
     *
     * @return string $file_url
     */
    public static function getStoreImage($file_name)
    {
        $fls_env = config('filesystems.default');
        try {
            $url = Storage::disk($fls_env)->url($file_name);
            return $url;
        } catch (\Exception $ex) {
            return "";
        }
    }

    /**
     * method may be used to remove file contents on a disk.
     * You may also pass a PHP resource to the get method,
     *
     * @param  string  $file_name
     *
     * @return bool TRUE/FALSE
     */
    public static function removeStoreImage($file_name)
    {
        $fls_env = config('filesystems.default');
        try {
            $url = Storage::disk($fls_env)->delete($file_name);
            return TRUE;
        } catch (\Exception $ex) {
            return FALSE;
        }
    }

    /**
     * get status badge or datatable
     *
     * @param       int         $status                 Status
     * @return      string      $formatedStatus         HTML formated status
     */
    public static function getStatus($status)
    {
        if ($status == STATUS_ACTIVE) {
            return '<span class="badge badge-success">Active</span>';
        } else if ($status == STATUS_INACTIVE) {
            return '<span class="badge badge-danger">Inactive</span>';
        } else if ($status == STATUS_PENDING) {
            return '<span class="badge badge-danger">Inactive</span>';
        }
    }

    /**
     * Get formatted email body
     *
     * @param       string          $emailBody              Email Body
     * @param       array           $data                   Email Parameters
     * @var         array           $data[links]            Links in email body
     * @var         array           $data[links][url]       Link URL
     * @var         array           $data[links][title]     Link Title
     * @var         string          $data[any]              Deault string parameters
     * @return      string          $emailBody              Formatted Email Body
     */
    public static function getFormattedEmailBody($emailBody, $data)
    {
        if (empty($emailBody)) {
            return '';
        }

        if (!empty($data) && is_array($data)) {

            if (!empty($data['links']) && is_array($data['links'])) {
                $links = $data['links'];
                unset($data['links']);

                foreach ($links as $key => $link) {
                    if (!empty($link['url'])) {
                        $linkTitle = !empty($link['title']) ? $link['title'] : 'Click Here';
                        $emailBody = str_replace($key, '<a href="' . $link['url'] . '" class="' . EMAIL_BTN_CLASSES . '">' . $linkTitle . '</a>', $emailBody);
                    }
                }
            }

            foreach ($data as $key => $parameter) {
                $emailBody = str_replace($key, $parameter, $emailBody);
            }
        }

        return $emailBody;
    }

    /**
     * Get all social media list. If key is empty all social medias will be returned
     *
     * @param       string      $key                    Social Media Key
     * @return      array       $socialMedia            Social media list
     */
    public static function getSocialMedia($key = null)
    {
        $socialMedia = array(
            'facebook'  =>  array(
                'title' => 'Facebook',
                'icon'  => '<i class="fab fa-facebook-f"></i>'
            ),
            'instagram'  =>  array(
                'title' => 'Instagram',
                'icon'  => '<i class="fab fa-instagram"></i>'
            ),
            'twitter'  =>  array(
                'title' => 'Twitter',
                'icon'  => '<i class="fab fa-twitter"></i>'
            ),
        );

        if ($key && !empty($socialMedia[$key])) {
            return $socialMedia[$key];
        } else {
            return $socialMedia;
        }
    }

    public static function isAdminUrl(){
        return (Request::is('admin/*')) ? true : false;
    }


}
