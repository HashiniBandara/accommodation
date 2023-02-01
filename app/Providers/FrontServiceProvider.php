<?php

namespace App\Providers;

use App\RoutePaths\Front\FrontRoutePath;
use Illuminate\Support\ServiceProvider;

class FrontServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = 'home';

    /**
     * Frontend pages array
     *
     * @var array
     */
    public const OTHER_PAGES = array(
        FrontRoutePath::BLOG => "Blog",
        FrontRoutePath::ACTIVITIES => "Activities",
        FrontRoutePath::DESTINATIONS => "Destinations",
        FrontRoutePath::ACCOMMODATIONS => "Accommodations",
        FrontRoutePath::ITINERARIES => "Itineraries",
        FrontRoutePath::TRANSPORT => "Transport",
        FrontRoutePath::EVENTS => "Events",
        FrontRoutePath::SPECIAL_OCCASIONS => "Special Occasions",
        FrontRoutePath::SPECIAL_OFFERS => "Special Offers",
        FrontRoutePath::ABOUT_US => "About Us",
    );
}
