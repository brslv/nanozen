<?php

namespace Nanozen\App;

use Nanozen\Providers\Config\ConfigProvider;
use Nanozen\Providers\CustomRouting\DispatchingProvider;
use Nanozen\Providers\CustomRouting\CustomRoutingProvider;

/**
 * Class SetsUpInjector
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
    	include '../src/container.php';
    }

}