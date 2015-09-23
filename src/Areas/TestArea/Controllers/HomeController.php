<?php 

namespace Nanozen\Areas\TestArea\Controllers;

use Nanozen\Providers\Controller\BaseControllerProvider as BaseController;

/**
 * Class HomeController
 *
 * @author brslv
 * @package Nanozen\Areas\TestArea\Controllers
 */
class HomeController extends BaseController 
{

	public function index()
	{
		echo "It's the TestArea's HomeController::index method. And it should work by default on /test.";
	}

}