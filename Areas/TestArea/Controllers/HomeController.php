<?php 

namespace Nanozen\Areas\TestArea\Controllers;

use Nanozen\Areas\TestArea\Controllers\BaseControllerTestArea;

/**
 * Class HomeController
 *
 * @author brslv
 * @package Nanozen\Areas\TestArea\Controllers
 */
class HomeController extends BaseControllerTestArea
{

	public function index()
	{
		echo "It's the TestArea's HomeController::index method. And it should work by default on /test.";
	}

	public function welcome()
	{
		echo "Welcome to the TestArea's HomeController::welcome().";
	}
	
	public function test()
	{
		$this->view()->render('home.bye');
	}

}