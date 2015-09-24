<?php

namespace Nanozen\Providers\AutoRouting;

use Nanozen\Providers\Routing\RoutingProvider;
use Nanozen\Contracts\Providers\AutoRouting\AutoRoutingProviderContract;

/**
* Class AutoRoutingProvider
*
* @author  brslv
* @package Nanozen\Providers\AutoRouting
*/
class AutoRoutingProvider extends RoutingProvider implements AutoRoutingProviderContract
{
	
	use MatchesRoutes;

	public $dependsOn = [
		'configProviderContract', 
		'dispatchingProviderContract', 
		'viewProviderContract'
	];

	public function invoke(array $customRoutes, array $areas)
	{
		$target = $this->matchAndPrefer($customRoutes, $areas);

		$this->dispatchingProviderContract->dispatch($target, null);
	}

}