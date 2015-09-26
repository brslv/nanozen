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
		'\Nanozen\Providers\Dispatching\DispatchingProvider');

Injector::prepare(
		InjectorTypes::TYPE_CLASS,
		'autoRoutingProviderContract',
		'\Nanozen\Providers\AutoRouting\AutoRoutingProvider');

Injector::prepare(
		InjectorTypes::TYPE_CLASS,
		'viewProviderContract',
		'\Nanozen\Providers\View\ViewProvider');
		
Injector::prepare(
		InjectorTypes::TYPE_CLASS,
		'commonDataInjector',
		'\Nanozen\Providers\View\CommonDataInjector');
		
Injector::prepare(
		InjectorTypes::TYPE_SINGLETON,
		'viewCommonDataProviderContract',
		'\Nanozen\Providers\View\ViewCommonDataProvider');

Injector::prepare(
		InjectorTypes::TYPE_SINGLETON, 
		'databaseProviderContract', 
		'\Nanozen\Providers\Database\DatabaseProvider',
		[
			'mysql',
			'localhost',
			'nanozen_framework',
			'root',
			'root',
		]);

Injector::prepare(
		InjectorTypes::TYPE_SINGLETON,
		'customRoutingProviderContract',
		'\Nanozen\Providers\CustomRouting\CustomRoutingProvider',
		[
				'\Nanozen\Providers\CustomRouting\DispatchingProvider',
		]);