<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ReviewServiceProvider extends ServiceProvider
{
    /**
     * Active categories status
     *
     * @var string
     */
    public const STATUS_ACTIVE = STATUS_ACTIVE;

    /**
     * Inactive categories sattus
     *
     * @var string
     */
    public const STATUS_INACTIVE = STATUS_INACTIVE;

    /**
     * Reviews list route
     *
     * @var string
     */
    public const REVIEW_LIST_ROUTE = "admin.review.list";
    
    /**
     * Reviews list ajax datatable route
     *
     * @var string
     */
    public const REVIEW_LIST_AJAX_ROUTE = "admin.review.list.ajax";

    /**
     * Create new review route 
     *
     * @var string
     */
    public const REVIEW_CREATE_ROUTE = "admin.review.create";

    /**
     * Create new review submit route 
     *
     * @var string
     */
    public const REVIEW_CREATE_SUBMIT_ROUTE = "admin.review.create.store";

    /**
     * Show review route 
     *
     * @var string
     */
    public const REVIEW_EDIT_ROUTE = "admin.review.show";
    
    /**
     * Update review route 
     *
     * @var string
     */
    public const REVIEW_EDIT_SUBMIT_ROUTE = "admin.review.update";

    /**
     * Delete review route 
     *
     * @var string
     */
    public const REVIEW_DELETE_SUBMIT_ROUTE = "admin.review.destroy";

    /**
     * Invalid review id message
     *
     * @var string
     */
    public const INVALID_REVIEW_MSG = "Invalid review id. Please try again.";

    /**
     * Rating categories
     *
     * @var string
     */
    public const RATING_CATEGORIES = array(
        'general'   => 'General',
        'food'      => 'Food',
        'service'   => 'Service',
        'room'      => 'Room',
        'location'  => 'Location',
    );
}
