<?php

namespace Nanozen\Providers\CustomRouting;

use Nanozen\App\Base;
use Nanozen\Providers\Routing\RoutingProvider;
use Nanozen\Contracts\Providers\CustomRouting\DispatchingProviderContract;
use Nanozen\Contracts\Providers\CustomRouting\CustomRoutingProviderContract;

/**
 * Class CustomRoutingProvider
 *
 * @author brslv
 * @package Nanozen\Providers\CustomRouting
 */
class CustomRoutingProvider extends RoutingProvider implements CustomRoutingProviderContract
{

    use AddsRoutes;
    use MatchesRoutes;

    public function addPattern($alias, $pattern)
    {
        $this->patterns[$alias] = $pattern;

        return $this->patterns;
    }

    public function invoke()
    {
        $target = $this->match();

        // Call the target controller/action
        // or perform the target closure.
        //
        // Provide target destination & extracted url variables.
        $this->dispatchingProviderContract->dispatch($target, $this->extractedVariables);
    }

}