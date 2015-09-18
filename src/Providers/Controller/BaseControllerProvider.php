<?php

namespace Nanozen\Providers\Controller;

use Nanozen\App\Base;

/**
 * Class BaseControllerProvider
 *
 * @author brslv
 * @package Nanozen\Providers\Controller
 */
class BaseControllerProvider
{

    protected $base;

    public function __construct(Base $base)
    {
        $this->base = $base;
    }

}