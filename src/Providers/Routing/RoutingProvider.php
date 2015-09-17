<?php

namespace Nanozen\Providers\Routing;

use Nanozen\Contracts\Providers\Routing\RoutingProviderContract;

/**
 * Class RoutingProvider
 *
 * @author brslv
 * @package Nanozen\Providers\Routing
 */
class RoutingProvider implements RoutingProviderContract
{

    use AddsRoutes;
    use MatchesRoutes;

    protected $routes = [
        'get' => [],
        'post' => [],
        'patch' => [],
        'put' => [],
        'delete' => [],
    ];

    protected $patterns = [
        ':i' => '#[0-9]+#',         // represents integers
        ':s' => '#[a-zA-Z]+#',      // represents strings
        ':a' => '#.+#',             // represents everything
    ];

    public function addPattern($alias, $pattern)
    {
        $this->patterns[$alias] = $pattern;

        return $this->patterns;
    }

    public function route()
    {
        if ($this->match()) {
            // call dispatcher.
        }
    }

}