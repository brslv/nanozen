<?php

namespace Nanozen\Providers\View;

/**
 * Trait FetchesViewCommonDataProviderDependencies
 * 
 * @author brslv
 * @package Nanozen\Providers\View
 */
trait FetchesViewCommonDataProviderDependencies
{
	
	public $dependsOn = [
		'databaseProviderContract',
		'configProviderContract',
	];
	
	/**
	 * @return \Nanozen\Providers\Database\DatabaseProvider
	 */
	protected function db()
	{
		return $this->databaseProviderContract;
	}
	
	/**
	 * @return \Nanozen\Providers\Config\ConfigProvider
	 */
	protected function config()
	{
		return $this->configProviderContract;
	}
	
}