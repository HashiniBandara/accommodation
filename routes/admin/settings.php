<?php

use App\RoutePaths\Admin\SettingsRoutePath;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Admin'], function () {

    Route::group(['middleware' => ['auth.admin']], function () {

        /*
        * settings routes
        */
        Route::get('settings/theme-settings', [
            'module' => 'theme_setting', 'uses' => 'Settings\SettingsController@theme_settings',
            'is_list' => TRUE, 'show_as' => 'Theme Settings'
        ])->name(SettingsRoutePath::THEME);

        Route::get('settings/email-settings', [
            'module' => 'email_setting', 'uses' => 'Settings\SettingsController@general_email_settings',
            'is_list' => TRUE, 'show_as' => 'General'
        ])->name(SettingsRoutePath::EMAIL);

        Route::post('settings/save/config', [
            'module' => 'settings', 'uses' => 'Settings\SettingsController@createOrUpdate',
            'is_list' => FALSE, 'show_as' => '', 'parent' => 'get.' . SettingsRoutePath::THEME
        ])->name(SettingsRoutePath::SAVE);

        /*
        * Navigation routes
        */
        Route::get('settings/navigation', [
            'module' => 'navigation', 'uses' => 'Settings\NavigationController@index',
            'is_list' => TRUE, 'show_as' => 'Navigation'
        ])->name(SettingsRoutePath::NAVIGATION);

        /*
        * Page routes
        */
        Route::get('pages/home', [
            'module' => 'pages', 'uses' => 'Pages\PagesController@home_settings',
            'is_list' => TRUE, 'show_as' => 'Home Page Settings'
        ])->name(SettingsRoutePath::HOME_PAGE);

        Route::get('pages/cards', [
            'module' => 'pages', 'uses' => 'Pages\PagesController@cardsListing',
            'is_list' => TRUE, 'show_as' => 'Cards Page Settings'
        ])->name(SettingsRoutePath::CARDS_PAGE);
        
        Route::get('pages/card/customize', [
            'module' => 'pages', 'uses' => 'Pages\PagesController@cardCustomize',
            'is_list' => TRUE, 'show_as' => 'Customize Card Page Settings'
        ])->name(SettingsRoutePath::CARD_CUSTOMIZE_PAGE);
        
        Route::get('pages/card/greeting', [
            'module' => 'pages', 'uses' => 'Pages\PagesController@greetingCard',
            'is_list' => TRUE, 'show_as' => 'Greeting Card Page Settings'
        ])->name(SettingsRoutePath::GREETING_CARD_PAGE);

        /*
        * end settings routes
        */
    });
});
