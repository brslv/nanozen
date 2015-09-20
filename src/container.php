<?php 

use Nanozen\App\Injector;
use Nanozen\App\InjectorTypes;

/**
 * Preparing some dependency injections.
 * 
 */

Injector::prepare(
		InjectorTypes::TYPE_CLASS,
		'ConfigProviderContract',
		'\Nanozen\Providers\Config\ConfigProvider');

Injector::prepare(
		InjectorTypes::TYPE_CLASS,
		'DispatchingProviderContract',
		'\Nanozen\Providers\CustomRouting\DispatchingProvider');

Injector::prepare(
		InjectorTypes::TYPE_SINGLETON,
		'CustomRoutingProviderContract',
		'\Nanozen\Providers\CustomRouting\CustomRoutingProvider',
		[
				'\Nanozen\Providers\CustomRouting\DispatchingProvider',
		]);