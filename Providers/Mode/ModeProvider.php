<?php

namespace Nanozen\Providers\Mode;

/**
 * Class ModeProvider
 *
 * @author brslv
 * @package Nanozen\Providers\Mode
 */
class ModeProvider
{

    private static $mode;

    const MODE_FILE_LOCATION = '../mode';

    const MODE_APP_LIVE = 'live';

    const MODE_APP_DEVELOPMENT = 'development';

    const MODE_APP_DEFAULT = self::MODE_APP_DEVELOPMENT;

    private function __construct() {}

    public static function get()
    {
        if (is_null(self::$mode)) {
            self::$mode = file_get_contents(self::MODE_FILE_LOCATION);

            if (self::$mode != self::MODE_APP_DEVELOPMENT &&
                self::$mode != self::MODE_APP_LIVE)
            {
                self::$mode = self::MODE_APP_DEFAULT;
            }
        }

        return self::$mode;
    }

}