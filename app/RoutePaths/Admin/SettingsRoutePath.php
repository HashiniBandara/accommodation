<?php
namespace App\RoutePaths\Admin;

abstract class SettingsRoutePath
{
    /** @var string */
    public const EMAIL = 'admin.settings.email';

    /** @var string */
    public const THEME = 'admin.settings.theme';

    /** @var string */
    public const SAVE = 'admin.settings.save';

    /** @var string */
    public const NAVIGATION = 'admin.settings.navigation';

    /**  @var string */
    public const HOME_PAGE = 'admin.pages.home';

    /** @var string */
    public const CARDS_PAGE = 'admin.pages.cards';
    
    /** @var string */
    public const CARD_CUSTOMIZE_PAGE = 'admin.pages.cards.customize';

    /** @var string */
    public const GREETING_CARD_PAGE = 'admin.pages.cards.greeting';
}
