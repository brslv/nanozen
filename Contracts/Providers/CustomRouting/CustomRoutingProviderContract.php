<?php

namespace Nanozen\Contracts\Providers\CustomRouting;

use Nanozen\Contracts\GenericRoutingContract;

/**
 * Interface RoutingProviderContract
 *
 * @author brslv
 * @package Nanozen\Contracts\Providers\CustomRouting
 */
interface CustomRoutingProviderContract
{

    function get($route, $target);

    function post($route, $target);

    function patch($route, $target);

    function put($route, $target);

    function delete($route, $target);

    function invoke();

}