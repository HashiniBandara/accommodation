<?php

namespace App\Messages\Admin;

abstract class AudienceMessage
{
    /** @var string */
    public const CREATE_FAILED = 'An error occurred while saving this audience.';

    /** @var string */
    public const CREATE_SUCCESS = 'Audience has been successfully added.';

    /** @var string */
    public const UPDATE_FAILED = 'An error occurred while updating this audience.';

    /** @var string */
    public const UPDATE_SUCCESS = 'Audience has been successfully updated.';

    /** @var string */
    public const DELETE_SUCCESS = 'The audience has been successfully deleted.';

    /** @var string */
    public const DELETE_FAILED = 'An error occurred while deleting this audience.';

    /** @var string */
    public const DELETE_USED = 'The selected audience cannot be deleted because this audience already used in the system.';

}