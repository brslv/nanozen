<?php

namespace Nanozen\App;

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

    public function __construct()
    {
        $this->router = new RoutingProvider();
    }

    public function run()
    {
        $this->router->get('/users/{id:i}', 'AlohaBaby');
        $this->router->route();
    }

}