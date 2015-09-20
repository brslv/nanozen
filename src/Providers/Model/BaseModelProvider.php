<?php

namespace Nanozen\Providers\Model;

/**
 * Class BaseModelProvider
 *
 * @author brslv
 * @package Nanozen\Providers\Model
 */
class BaseModelProvider
{

    /**
     * This class depends on ConfigProviderContract.
     *
     * @var \Nanozen\Providers\Config\ConfigProvider
     */
    public $dependsOn = ['ConfigProviderContract'];

}