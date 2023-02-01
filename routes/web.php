<?php

use App\Http\Controllers\Customer\LoginController;
use App\Http\Controllers\Customer\RegisterController;
use App\Http\Controllers\Front\AccommodationController;
use App\Http\Controllers\Front\ActivityController;
use App\Http\Controllers\Front\CardController;
use App\Http\Controllers\Front\DestinationController;
use App\Http\Controllers\Front\EventController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\InquiryController;
use App\Http\Controllers\Front\ItineraryController;
use App\Http\Controllers\Front\OtherPagesController;
use App\Http\Controllers\Front\PostController;
use App\Http\Controllers\Front\TransportController;
use App\Providers\AdminServiceProvider;
use App\RoutePaths\Front\FrontRoutePath;
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

Route::get('/', [HomeController::class, 'index'])->name(FrontRoutePath::HOME_PAGE);

Route::get('/admin', function () {
    return redirect()->route(AdminServiceProvider::BACKEND_DASHBOARD_ROUTE);
});
