<?php

namespace Nanozen\Providers\CustomRouting;

use Nanozen\Contracts\Providers\CustomRouting\DispatchingProviderContract;
use Nanozen\Contracts\Providers\CustomRouting\CustomRoutingProviderContract;

/**
 * Class CustomRoutingProvider
 *
 * @author brslv
 * @package Nanozen\Providers\CustomRouting
 */
class CustomRoutingProvider implements CustomRoutingProviderContract
{

    use AddsRoutes;
    use MatchesRoutes;

    protected $dispatcher;

    public $routes = [
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

    public function __construct(DispatchingProviderContract $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

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
        $this->dispatcher->dispatch($target, $this->extractedVariables);
    }

}