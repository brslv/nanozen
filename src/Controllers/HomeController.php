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
        echo Form::check('checking', 10, null, 'Chckbox, baby!') . '<br />';
        echo Form::dropdown('dropdownNameHere', [
            'volvo' => 'Volvo',
            'mercedes' => 'Mercedes',
        ]);
        echo Form::password('pass', ['style' => 'height: 60px;']);

        echo Form::textarea('textareaTest', ['style' => 'width: 100%; height: 200px;']);

        echo "Bye, bye, whoever you were.";
    }

    public function automatic()
    {
        echo "Automatic route";
    }

}