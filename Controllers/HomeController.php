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
     * To set required object (static view):
     * $this->view()->uses('\Some\Model\Example')->render('home.example', compact('exampleObject'));
     *
     * To set escaping to false for this view:
     * $this->view()->escape(false); 
     */

    /**
     * @bind \Nanozen\Models\Binding\UserBinding
     */
    public function welcome()
    {
        $welcome = 'This is Nanozen.';
        $this->view()->slogan = '~ A journey of a thousand miles begins with a single step.';
        var_dump($this->binding);

        // Calls view in the folder Views/home -> welcome.php.
        // Passes the $welcome variable to the view.
        // There can be accessed like this:
        // $this->welcome;
        $this->view()->render('home.welcome', compact('welcome'));
    }

    public function form()
    {
        echo Form::start('process', 'put');
        echo Form::submit('submitButton');
        echo Form::stop();
    }

    public function process()
    {
        echo 'processing';
    }

    public function auto()
    {
        echo 'automatically routed to here';
    }
    
}