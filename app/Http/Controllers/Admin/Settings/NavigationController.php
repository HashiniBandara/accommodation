<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
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

class NavigationController extends Controller
{
    protected $search_columns = ["id", "module", "key", "value"];

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
     * Display navigation settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $navigation = getSettingValue(config('settings.theme_key'), 'navigation');

        $navigation = !empty($navigation) ? $navigation : [];

        return view('admin.settings.navigation')
            ->with([
                'title'                     => 'Navigation',
                'itineraries'               => $this->itineraryRepository->geItinerariesWithPaginate(NULL),
                'itineraryCategories'       => $this->itineraryCategoryRepository->getAllActiveCategories(),
                'accommodations'            => $this->accommodationRepository->geAccommodationsWithPaginate(NULL),
                'accommodationCategories'   => $this->accommodationCategoryRepository->getAllActiveCategories(),
                'activities'                => $this->activityRepository->geActivitiesWithPaginate(NULL),
                'activityCategories'        => $this->activityCategoryRepository->getAllActiveCategories(),
                'destinations'              => $this->destinationRepository->gedestinationsWithPaginate(NULL),
                'destinationCategories'     => $this->destinationCategoryRepository->getAllActiveCategories(),
                'otherPages'                => FrontServiceProvider::OTHER_PAGES,
                'navHTMLList'               => $this->getNavHTMLList($navigation)
            ]);
    }

    /**
     * Get navigation item childrens with links
     * 
     * @param       array       $navigation         Navigation Item      
     */
    function getNavHTMLList($navigation)
    {
        $html = '';
        $menuID = 0;
        foreach ($navigation as &$navItem) {
            if (empty($navItem['value']['type'])) {
                continue;
            }
            $menuID++;
            if ($navItem['value']['type'] == 'custom') {
                $html .= '<li class="menu-item s-l-open" id="' . $menuID . '"
                data-value=\'{"type":"custom","title":"' . str_replace("'", "&apos;", $navItem['value']['title']) . '","link":"' . $navItem['value']['link'] . '","target":"' . $navItem['value']['target'] . '"}\'
                style="width: auto; position: relative; top: 0px; left: 0px;">
                <div class="btn btn btn-outline-primary w-100 mb-2">
                    <span class="title">' . $navItem['value']['title'] . '</span>
                    <div>
                        <a href="#" data-parent="' . $menuID . '" class="edit clickable btn btn-xs btn-icon bg-light mr-5"><i class="fas fa-pen text-info clickable"></i></a>
                    <a href="#" class="remove clickable btn btn-xs btn-icon bg-light">
                        <i class="fas fa-trash text-danger clickable"></i>
                    </a>
                    </div>
                </div>';
            } elseif ($navItem['value']['type'] == 'other') {
                if (!empty(FrontServiceProvider::OTHER_PAGES[$navItem['value']['value']])) {
                    $label = FrontServiceProvider::OTHER_PAGES[$navItem['value']['value']];
                    $html .= '<li class="menu-item s-l-open" id="' . $menuID . '"
                    data-value=\'{"type":"' . $navItem['value']['type'] . '","title":"' . str_replace("'", "&apos;", $navItem['value']['title']) . '","value":"' . $navItem['value']['value'] . '"}\'
                    style="width: auto; position: relative; top: 0px; left: 0px;">
                    <div class="btn btn btn-outline-primary w-100 mb-2">
                        <span class="title">' . $label . ' : <span class="edit-title">' . $navItem['value']['title'] . '</span></span>
                        <div>
                        <a href="#" data-parent="' . $menuID . '" class="edit clickable btn btn-xs btn-icon bg-light mr-5"><i class="fas fa-pen text-info clickable"></i></a>
                        <a href="#" class="remove clickable btn btn-xs btn-icon bg-light">
                            <i class="fas fa-trash text-danger clickable"></i>
                        </a>
                        </div>
                        </div>';
                }
            } else {
                if ($navItem['value']['type'] == 'itinerary') {
                    $label = 'Itinerary';
                } elseif ($navItem['value']['type'] == 'itineraryCategories') {
                    $label = 'Itinerary Category';
                } elseif ($navItem['value']['type'] == 'accommodation') {
                    $label = 'Accommodation';
                } elseif ($navItem['value']['type'] == 'accommodationCategories') {
                    $label = 'Accommodation Category';
                } elseif ($navItem['value']['type'] == 'activity') {
                    $label = 'Activity';
                } elseif ($navItem['value']['type'] == 'activityCategories') {
                    $label = 'Activity Category';
                } elseif ($navItem['value']['type'] == 'destination') {
                    $label = 'Destination';
                } elseif ($navItem['value']['type'] == 'destinationCategories') {
                    $label = 'Destination Category';
                }
                $html .= '<li class="menu-item s-l-open" id="' . $menuID . '"
                    data-value=\'{"type":"' . $navItem['value']['type'] . '","title":"' . str_replace("'", "&apos;", $navItem['value']['title']) . '","value":"' . $navItem['value']['value'] . '"}\'
                    style="width: auto; position: relative; top: 0px; left: 0px;">
                    <div class="btn btn btn-outline-primary w-100 mb-2">
                        <span class="title">' . $label . ' : <span class="edit-title">' . $navItem['value']['title'] . '</span></span>
                        <div>
                        <a href="#" data-parent="' . $menuID . '" class="edit clickable btn btn-xs btn-icon bg-light mr-5"><i class="fas fa-pen text-info clickable"></i></a>
                        <a href="#" class="remove clickable btn btn-xs btn-icon bg-light">
                            <i class="fas fa-trash text-danger clickable"></i>
                        </a>
                        </div>
                        </div>';
            }
            if (!empty($navItem['children'])) {
                $html .= '<ul>';
                $html .= $this->getNavHTMLList($navItem['children']);
                $html .= '</ul>';
            }
            $html .= '</li>';
        }
        return $html;
    }
}
