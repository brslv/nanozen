<?php

namespace Nanozen\Contracts\Providers\View;

/**
 * Interface ViewCommonDataProviderContract
 * 
 * @author brslv
 * @package Nanozen\Contracts\Providers\View
 */
interface ViewCommonDataProviderContract
{
	
	function getCommonData();
	
	function setCommonData(array $commonData);
	
}