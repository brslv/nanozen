<?php

namespace Nanozen\Providers\Controller;

/**
 * Abstract class ControllerAbstract
 * 
 * @author brslv
 * @package Nanozen\Providers\Controller
 */
abstract class ControllerAbstract
{
	
	public $dependsOn = [
			'configProviderContract',
			'viewProviderContract',
			'databaseProviderContract',
	];
	
	public $binding;
	
	/**
	 * @return Nanozen\Providers\View
	 */
	protected function view()
	{
		// Sets the Views folder path.
		$this->viewProviderContract->setPath($this->configProviderContract->get('paths.views'));
	
		// Returns the viewProviderContract.
		return $this->viewProviderContract;
	}
	
	/**
	 * @return \Nanozen\Providers\Database\DatabaseProvider
	 */
	protected function db()
	{
		return $this->databaseProviderContract;
	}
	
}