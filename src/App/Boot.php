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

        // If you want to use the container inside the closure
        // pass $base to it.
        $this->container->resolve('router')->get('/closure', function ($base) {
            echo $base->container->resolve('me');
        });

        $this->container->resolve('router')->get('aloha/{name:a}', 'HomeController@aloha');

        $this->container->resolve('router')->get('bye', 'HomeController@bye');

        // Invoking the router.
        $this->container->resolve('router')->invoke();
    }

}