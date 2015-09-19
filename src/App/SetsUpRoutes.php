<?php

namespace Nanozen\App;

/**
 * Trait SetsUpRoutes
 * 
 * @author brslv
 * @package Nanozen\App;
 */
trait SetsUpRoutes 
{
	
	public function setupRoutes()
	{
		$route = $this->container->resolve('router');
		
		include $this->container->resolve('config')->get('paths.routes_file');
	}
	
}