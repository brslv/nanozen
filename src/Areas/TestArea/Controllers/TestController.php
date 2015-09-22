<?php

namespace Nanozen\Areas\TestArea\Controllers;

use Nanozen\Providers\Controller\BaseControllerProvider as BaseController;

/**
* Class TestController
*/
class TestController extends BaseController
{

	public function index()
	{
		echo "Hi from TestController::index.";
	}

	public function home()
	{
		echo 'Hi from TestController::home()';
	}

}