<?php

namespace Nanozen\Contracts\Providers\AutoRouting;

/**
 * Interface AutoRoutingProviderContract
 *
 * @author brslv
 * @package Nanozen\Contracts\Providers\AutoRouting
 */
interface AutoRoutingProviderContract
{

	function invoke(array $customRoutes, array $areas);

}