<?php

namespace Nanozen\Contracts\Providers\View;

/**
 * Interface ViewProviderContract 
 *
 * @author brslv
 * @package Nanozen\Contracts\View 
 */
interface ViewProviderContract 
{

	function setPath($path);

	function render($view, $data);
	
}