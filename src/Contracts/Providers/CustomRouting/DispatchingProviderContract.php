<?php

namespace Nanozen\Contracts\Providers\CustomRouting;
use Nanozen\App\Base;

/**
 * Interface DispatchingProviderContract
 *
 * @author brslv
 * @package Nanozen\Contracts\Providers\CustomRouting
 */
interface DispatchingProviderContract
{

    function dispatch($target, $variables, Base $base);

}