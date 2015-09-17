<?php

namespace Nanozen\Providers\Routing;

/**
 * Trait AddsRoutes
 *
 * @author brslv
 * @package Nanozen\Providers\Routing
 */
trait AddsRoutes
{
    public function get($route, $target)
    {
        $this->routes['get'][$route] = $target;
    }

    public function post($route, $target)
    {
        $this->routes['post'][$route] = $target;
    }

    public function patch($route, $target)
    {
        $this->routes['patch'][$route] = $target;
    }

    public function put($route, $target)
    {
        $this->routes['put'][$route] = $target;
    }

    public function delete($route, $target)
    {
        $this->routes['delete'][$route] = $target;
    }
}