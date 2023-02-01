<?php

namespace App\Repositories;

use App\Model\Settings;

class SettingsRepository
{
    /**
     * returns the setting record which is matching given module and key
     *
     * @param string $module
     * @param string $key
     * @return Settings
     */
    public function get($module, $key)
    {
        return Settings::where(['deleted_at' =>  NULL, 'module' =>  $module, 'key' =>  $key])->get()->first();
    }

    /**
     * returns the setting value which is matching given module and key
     *
     * @param $module
     * @param $key
     * @return string
     */
    public function getValue($module, $key)
    {
        $setting = $this->get($module, $key);

        if(!empty($setting->value)){
            if(is_array(json_decode($setting->value, true))){
                return json_decode($setting->value, true);
            } else {
                return $setting->value;
            }
        } else {
            return "";
        }
    }

    /**
     * returns the existence of a setting record which is matching given module and key
     *
     * @param $module
     * @param $key
     * @return bool
     */
    public function isExist($module, $key)
    {
        return !$this->isNotExist($module, $key);
    }

    /**
     * returns the not existence of a setting record which is matching given module and key
     *
     * @param $module
     * @param $key
     * @return bool
     */
    public function isNotExist($module, $key)
    {
        return empty($this->get($module, $key));
    }

    /**
     * set value to given key and module
     *
     * @param string $module
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function setValue($module, $key, $value)
    {
        $setting = $this->get($module, $key);
        if (empty($setting)) {
            $setting = new Settings();
            $setting->created_at = now();
            $setting->status = config('settings.status.active');
        } else {
            $setting->updated_at = now();
        }
        $setting->key = $key;
        $setting->module = $module;
        $setting->value = $value;
        return $setting->save();
    }

    /**
     * remove a setting which is matching with given module and key
     *
     * @param $module
     * @param $key
     * @return boolean
     */
    public function removeValue($module, $key)
    {
        return Settings::where(['module' =>  $module, 'key' =>  $key])->update(['deleted_at' => now()]);
    }

    public function getByModule($module)
    {

        $data = Settings::where(['module' => $module, 'deleted_at' => NULL])->get();

        $filteredData = [];
        if (!empty($data)) {
            foreach ($data as $key => $settingItem) {
                if (is_array(json_decode($settingItem->value, TRUE))) {
                    $filteredData[$settingItem->key] = json_decode($settingItem->value, TRUE);
                } else {
                    $filteredData[$settingItem->key] = $settingItem->value;
                }
            }
        }

        return $filteredData;
    }
}
