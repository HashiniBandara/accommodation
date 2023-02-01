<?php

namespace App\Http\Middleware;

use App\Providers\FrontServiceProvider;
use App\Repositories\AccommodationCategoryRepository;
use App\Repositories\AccommodationRepository;
use App\Repositories\ActivityCategoryRepository;
use App\Repositories\ActivityRepository;
use App\Repositories\DestinationCategoryRepository;
use App\Repositories\DestinationRepository;
use App\Repositories\ItineraryCategoryRepository;
use App\Repositories\ItineraryRepository;
use App\Repositories\SettingsRepository;
use Closure;
use Illuminate\Support\Facades\View;

class Navigation
{
    /** @var SettingsRepository */
    private $settingsRepository;

    /** @var ItineraryRepository */
    private $itineraryRepository;

    /** @var ItineraryCategoryRepository */
    private $itineraryCategoryRepository;

    /**
     * @var DestinationRepository
     */
    private $destinationRepository;

    /**
     * @var DestinationCategoryRepository;
     */
    private $destinationCategoryRepository;

    /**
     * @var ActivityRepository
     */
    private $activityRepository;

    /**
     * @var ActivityCategoryRepository
     */
    private $activityCategoryRepository;

    /**
     * @var AccommodationRepository
     */
    private $accommodationRepository;

    /**
     * @var AccommodationCategoryRepository
     */
    private $accommodationCategoryRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        SettingsRepository $settingsRepository,
        ItineraryRepository $itineraryRepository,
        ItineraryCategoryRepository $itineraryCategoryRepository,
        AccommodationRepository $accommodationRepository,
        AccommodationCategoryRepository $accommodationCategoryRepository,
        DestinationRepository $destinationRepository,
        DestinationCategoryRepository $destinationCategoryRepository,
        ActivityRepository  $activityRepository,
        ActivityCategoryRepository  $activityCategoryRepository
    ) {
        $this->settingsRepository = $settingsRepository;
        $this->itineraryRepository = $itineraryRepository;
        $this->itineraryCategoryRepository = $itineraryCategoryRepository;
        $this->accommodationRepository = $accommodationRepository;
        $this->accommodationCategoryRepository = $accommodationCategoryRepository;
        $this->destinationRepository = $destinationRepository;
        $this->destinationCategoryRepository = $destinationCategoryRepository;
        $this->activityRepository = $activityRepository;
        $this->activityCategoryRepository = $activityCategoryRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $navigation = getSettingValue(config('settings.theme_key'), 'navigation');

        $navigation = !empty($navigation) ? $navigation : [];

        View::share('mainNavigation', $this->getNavHTML($navigation));

        return $next($request);
    }

    /**
     * Get navigation html view
     * 
     * @param       array       $navigation         Navigation Item      
     */
    private function getNavHTML($navigation)
    {
        $html = '<ul>';

        foreach ($navigation as &$navItem) {
            $hasChildren = (!empty($navItem['children'])) ? true : false;

            if(empty($navItem['value']['type'])){
                continue;
            }

            if ($navItem['value']['type'] == 'custom') {
                $html .= '<li class="' . (($hasChildren) ? 'has-sub-menu' : '') . '">';
                $html .= '<a href="' . $navItem['value']['link'] . '" target="'.($navItem['value']['target']).'">' . $navItem['value']['title'] . '</a>';
            } elseif ($navItem['value']['type'] == 'other') {
                if (!empty(FrontServiceProvider::OTHER_PAGES[$navItem['value']['value']])) {
                    $html .= '<li class="' . (($hasChildren) ? 'has-sub-menu' : '') . '">';
                    $html .= '<a href="' . route($navItem['value']['value']) . '">' . $navItem['value']['title'] . '</a>';
                }
            } else {
                if ($navItem['value']['type'] == 'itinerary') {
                    $item = $this->itineraryRepository->get($navItem['value']['value']);
                } elseif ($navItem['value']['type'] == 'itineraryCategories') {
                    $item = $this->itineraryCategoryRepository->get($navItem['value']['value']);
                } elseif ($navItem['value']['type'] == 'destination') {
                    $item = $this->destinationRepository->get($navItem['value']['value']);
                } elseif ($navItem['value']['type'] == 'destinationCategories') {
                    $item = $this->destinationCategoryRepository->get($navItem['value']['value']);
                } elseif ($navItem['value']['type'] == 'activity') {
                    $item = $this->activityRepository->get($navItem['value']['value']);
                } elseif ($navItem['value']['type'] == 'activityCategories') {
                    $item = $this->activityCategoryRepository->get($navItem['value']['value']);
                } elseif ($navItem['value']['type'] == 'accommodation') {
                    $item = $this->accommodationRepository->get($navItem['value']['value']);
                } elseif ($navItem['value']['type'] == 'accommodationCategories') {
                    $item = $this->accommodationCategoryRepository->get($navItem['value']['value']);
                }

                if (!empty($item->url)) {
                    $html .= '<li class="' . (($hasChildren) ? 'has-sub-menu' : '') . '">';
                    $html .= '<a href="' . $item->url . '">' . $navItem['value']['title'] . '</a>';
                }
            }

            if ($hasChildren) {
                $html .= $this->getNavHTML($navItem['children']);
            }

            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }
}
