<?php

namespace Nanozen\App;

use Nanozen\Contracts\Providers\CustomRouting\CustomRoutingProviderContract;

/**
 * Trait SetsUpRoutes
 * 
 * @author brslv
 * @package Nanozen\App;
 */
trait SetsUpRoutes 
{
	
	public function setupRoutes(CustomRoutingProviderContract $router)
	{
		include Injector::call('\Nanozen\Providers\Config\ConfigProvider')->get('paths.routes_file');
	}
	
}