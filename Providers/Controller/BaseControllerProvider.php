<?php

namespace Nanozen\Providers\Controller;

use Nanozen\App\Base;

/**
 * Class BaseControllerProvider
 *
 * @author brslv
 * @package Nanozen\Providers\Controller
 */
class BaseControllerProvider
{

    public $dependsOn = [
    	'configProviderContract', 
    	'viewProviderContract',
    	'databaseProviderContract',
    ];

    public $binding;

    protected function view()
    {
    	// Sets the Views folder path.
    	$this->viewProviderContract->setPath($this->configProviderContract->get('paths.views'));

    	// Returns the viewProviderContract. 
    	return $this->viewProviderContract;
    }
    
    protected function db() 
    {
		return $this->databaseProviderContract;    	
    }

}