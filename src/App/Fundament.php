<?php

namespace Nanozen\App;

use Nanozen\Providers\Routing\DispatchingProvider;
use Nanozen\Providers\Routing\RoutingProvider;

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
        $this->router = new RoutingProvider($this->dispatcher);
    }

    public function run()
    {
        // Setting routes.
        $this->router->get('/', 'HomeController@welcome');
        $this->router->get('aloha/{name:s}', 'HomeController@aloha');
        $this->router->get('bye', 'HomeController@bye');

        // Invoking the router.
        $this->router->invoke();
    }

}