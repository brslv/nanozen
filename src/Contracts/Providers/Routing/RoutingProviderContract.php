<?php

namespace Nanozen\Contracts\Providers\Routing;

/**
 * Interface RoutingProviderContract
 *
 * @author brslv
 * @package Nanozen\Contracts\Providers\Routing
 */
interface RoutingProviderContract
{

    function get($route, $target);

    function post($route, $target);

    function patch($route, $target);

    function put($route, $target);

    function delete($route, $target);

    function route();

    function match();

}