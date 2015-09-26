<?php

namespace Nanozen\Controllers;

use Nanozen\Providers\Controller\BaseControllerProvider as BaseController;
use Nanozen\Providers\Session\SessionProvider as Session;
use Nanozen\Utilities\Csrf;
use Nanozen\Utilities\Html\Form;

/**
 * Class HomeController
 *
 * @author brslv
 * @package Nanozen\Controllers
 */
class HomeController extends BaseController
{

    /**
     * This view is here just to test
     * rendering views.
     */
    public function welcome()
    {
        $welcome = 'This is Nanozen.';
        $this->view()->slogan = '~ A journey of a thousand miles begins with a single step.';

        // Calls view in the folder Views/home -> welcome.php.
        // Passes the $welcome variable to the view.
        // There can be accessed like this:
        // $this->welcome;
        $this->view()->render('home.welcome', compact('welcome'));
    }

    /**
     * This view is here just to test
     * the form building functionality.
     */
    public function form()
    {
    	echo Form::start('process', 'put');
        echo Form::text('name');
        echo Form::text('age');
        echo Form::submit('submitButton');
        echo Form::stop();
    }
	
    /**
     * This view is here just to test
     * the model-binding functionality.
     * 
     * @bind \Nanozen\Models\Binding\UserBinding
     */
    public function process()
    {
    	echo $this->binding->getInfo();
    }
    
    /**
     * This action is here just to test
     * the database and the strongly-typed
     * views functionality.
     */
    public function testsStrongView()
    {
		$someRandomUsersFromDb = $this->db()->prepare("SELECT * FROM users WHERE password = :password");
		$someRandomUsersFromDb->execute([':password' => '123']);
		
		// doesn't work with this object.
		$dbUser = $someRandomUsersFromDb->fetch()[0];
		
		// Works with this object.
		$user = new \Nanozen\Models\User();
		$user->username = $dbUser->username;
		$user->password = $dbUser->password;
		
		$this->view()->uses('Nanozen\Models\User')->render('home.testsStrongView', compact('user'));
    }

    /**
     * This action is here just to test
     * the automatic route matching functionality
     * of the framework.
     */
    public function auto()
    {
        echo 'automatically routed to here';
    }
    
}