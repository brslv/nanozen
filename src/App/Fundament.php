<?php

namespace Nanozen\App;

use Nanozen\Providers\CustomRouting\DispatchingProvider;
use Nanozen\Providers\CustomRouting\CustomRoutingProvider;

/**
 * Class Fundament
 *
 * @author brslv
 * @package Nanozen\App
 */
class Fundament
{

    protected $router;

    protected $dispatcher;

    public function __construct()
    {
        $this->dispatcher = new DispatchingProvider();
        $this->router = new CustomRoutingProvider($this->dispatcher);
    }

    public function run()
    {
        // Setting routes.
        $this->router->get('/', 'HomeController@welcome');
        $this->router->get('aloha/{name:a}', 'HomeController@aloha');
        $this->router->get('bye', 'HomeController@bye');

        // Invoking the router.
        $this->router->invoke();
    }

}