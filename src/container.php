<?php 

use Nanozen\App\Injector;
use Nanozen\App\InjectorTypes;

/**
 * Preparing some dependency injections.
 * 
 */

Injector::prepare(
		InjectorTypes::TYPE_CLASS,
		'configProviderContract',
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