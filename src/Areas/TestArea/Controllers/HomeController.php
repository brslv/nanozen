<?php 

namespace Nanozen\Areas\TestArea\Controllers;

use Nanozen\Providers\Controller\BaseControllerProvider as BaseController;

class HomeController extends BaseController 
{

	public function index()
	{
		echo "It's the TestArea's HomeController::index method. And it should work by default on /test.";
	}

	public function welcome() 
	{
		echo 'A simple welcomming message.';
	}

}