<?php

namespace Nanozen\Contracts\Providers\Routing;

/**
 * Interface DispatchingProviderContract
 *
 * @author brslv
 * @package Nanozen\Contracts\Providers\Routing
 */
interface DispatchingProviderContract
{

    function dispatch($target, $variables);

}