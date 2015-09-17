<?php

namespace Nanozen\App;

/**
 * Class Fundament
 *
 * @author brslv
 * @package Nanozen\App
 */
class Fundament
{

    use SetsUpContainer;

    protected $container;

    public function __construct()
    {
        $this->setupContainer()
             ->populateContainer()
             ->run();
    }

    public function run()
    {
        // Setting routes.
        $this->container->resolve('router')->get('/', 'HomeController@welcome');
        $this->container->resolve('router')->get('aloha/{name:a}', 'HomeController@aloha');
        $this->container->resolve('router')->get('bye', 'HomeController@bye');

        // Invoking the router.
        $this->container->resolve('router')->invoke();
    }

}