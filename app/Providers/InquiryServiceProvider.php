<?php

namespace App\Providers;

use App\Repositories\CountryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\ServiceProvider;

class InquiryServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    public const TYPE_ACTIVITY = 'activity';
    
    /**
     * @var string
     */
    public const TYPE_ACCOMMODATION = 'accommodation';
    
    /**
     * @var string
     */
    public const TYPE_DESTINATION = 'destination';
    
    /**
     * @var string
     */
    public const TYPE_ITINERARY = 'itinerary';
    
    /**
     * @var string
     */
    public const TYPE_EVENT = 'event';

    /**
     * Get all countries
     * 
     * @return      Collection
     */
    public static function getAllCountries()
    {
        $countryRepository = app()->get(CountryRepository::class);
        return $countryRepository->getAll();
    }
}
