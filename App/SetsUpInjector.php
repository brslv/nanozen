<?php

namespace Nanozen\App;

use Nanozen\Providers\Config\ConfigProvider;
use Nanozen\Providers\CustomRouting\DispatchingProvider;
use Nanozen\Providers\CustomRouting\CustomRoutingProvider;

/**
 * Trait SetsUpInjector
 *
 * @author brslv
 * @package Nanozen\App
 */
trait SetsUpInjector
{

	/**
	 * Prepares some injections.
	 * 
	 * @return void
	 */
    public function setupInjector()
    {   
    	include '../container.php';
    }

}