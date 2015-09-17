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

    protected $container;

    public function __construct()
    {
        $this->setupContainer()
             ->populateContainer()
             ->run();
    }

    protected function setupContainer()
    {
        $this->container = new Container();

        return $this;
    }

    public function populateContainer()
    {
        $container = $this->container;

        $this->container->register('dispatcher', function () {
            return new DispatchingProvider();
        });

        $this->container->share('router', function () use ($container) {
            return new CustomRoutingProvider($container->resolve('dispatcher'));
        });

        return $this;
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