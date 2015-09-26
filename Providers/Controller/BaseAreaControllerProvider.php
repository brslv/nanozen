<?php

namespace Nanozen\Providers\Controller;

/**
 * 
 * @author brslv
 * @package Nanozen\Providers\Controller
 */
class BaseAreaControllerProvider extends ControllerAbstract
{
	
	/**
	 * @return Nanozen\Providers\View
	 */
	protected function view()
	{
		// Returns the viewProviderContract.
		return $this->viewProviderContract;
	}
	
}