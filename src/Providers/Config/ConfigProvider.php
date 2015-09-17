<?php

namespace Nanozen\Providers\Config;

use Nanozen\Providers\Mode\ModeProvider as Mode;

/**
 * Class ConfigProvider
 *
 * @author brslv
 * @package Nanozen\Providers\Config
 */
class ConfigProvider
{

    public function __construct()
    {
        echo Mode::get();
    }

}