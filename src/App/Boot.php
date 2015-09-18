<?php

namespace Nanozen\App;

/**
 * Class Boot
 *
 * @author brslv
 * @package Nanozen\App
 */
class Boot
{

    use SetsUpContainer;
    use SetsUpBase;

    protected $container;

    protected $base;

    public function __construct()
    {
        $this->setupContainer();
        $this->setupBase();
        $this->populateContainer();
        $this->run();
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