<?php

namespace Nanozen\Controllers;

use Nanozen\Providers\Controller\BaseControllerProvider as BaseController;

/**
 * Class HomeController
 *
 * @author brslv
 * @package Nanozen\Controllers
 */
class HomeController extends BaseController
{

    /**
     * Experimentin'
     *
     */
    public function welcome()
    {
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

}