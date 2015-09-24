<?php

namespace Nanozen\Contracts\Providers\Dispatching;

use Nanozen\App\Base;

/**
 * Interface DispatchingProviderContract
 *
 * @author brslv
 * @package Nanozen\Contracts\Providers\Dispatching
 */
interface DispatchingProviderContract
{

    function dispatch($target, $variables);

}