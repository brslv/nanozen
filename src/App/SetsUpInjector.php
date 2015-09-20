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
        Injector::prepare(
    			InjectorTypes::TYPE_CLASS, 
    			'configProvider', 
    			'\Nanozen\Providers\Config\ConfigProvider');
        
        Injector::prepare(
        		InjectorTypes::TYPE_CLASS, 
        		'dispatchingProviderContract', 
        		'\Nanozen\Providers\CustomRouting\DispatchingProvider');
        
        Injector::prepare(
        		InjectorTypes::TYPE_SINGLETON,
        		'customRoutingProviderContract',
        		'\Nanozen\Providers\CustomRouting\CustomRoutingProvider',
        		[
        			'\Nanozen\Providers\CustomRouting\DispatchingProvider',
        		]);
    }

}