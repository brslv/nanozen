<?php

namespace Nanozen\Controllers;

use Nanozen\Providers\Controller\BaseControllerProvider as BaseController;
use Nanozen\Providers\Session\SessionProvider as Session;
use Nanozen\Utilities\Csrf;

/**
 * Class HomeController
 *
 * @author brslv
 * @package Nanozen\Controllers
 */
class HomeController extends BaseController
{

    /**
     * The default action.
     * 
     * @return void
     */
    public function index()
    {
        echo "HomeController::index.";
    }

    /**
     * Experimenting.
     *
     */
    public function welcome()
    {
        print_r(Session::get());
        $name = 'Stranger';

        $this->aloha($name);
    }

    public function aloha($name)
    {
        echo "Aloha, " . $name . ".";
    }

    public function bye()
    {
        echo "Bye, bye, whoever you were.";
    }

    public function automatic()
    {
        echo "Automatic route";
    }

}