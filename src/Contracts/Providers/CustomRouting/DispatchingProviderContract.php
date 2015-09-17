<?php

namespace Nanozen\Contracts\Providers\CustomRouting;

/**
 * Interface DispatchingProviderContract
 *
 * @author brslv
 * @package Nanozen\Contracts\Providers\CustomRouting
 */
interface DispatchingProviderContract
{

    function dispatch($target, $variables);

}