<?php

namespace Nanozen\Areas\TestArea\Controllers;

use Nanozen\Providers\Controller\BaseAreaControllerProvider;
/**
 * Class BaseControllerTestArea
 * 
 * @author brslv
 * @package Nanozen\Areas\TestArea\Controllers
 */
class BaseControllerTestArea extends BaseAreaControllerProvider
{
	
	protected $viewsPathForThisArea = '../Areas/TestArea/Views/';
	
	protected function view()
	{	
		$this->viewProviderContract->setPath($this->viewsPathForThisArea);
		
		return parent::view();
	}
	
}