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

    public function welcome()
    {
        $welcome = 'This is Nanozen.';

        // Uncomment the row below, if you want to cansel html escaping.
        // $this->view()->escape(false);

        // Calls view in the folder Views/home -> welcome.php.
        // Passes the $welcome variable to the view.
        // There can be accessed like this:
        // $this->welcome;
        $this->view()->render('home.welcome', compact('welcome'));
    }
    
}