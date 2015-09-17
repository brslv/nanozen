<?php

namespace Nanozen\App;

use Nanozen\Providers\CustomRouting\DispatchingProvider;
use Nanozen\Providers\CustomRouting\CustomRoutingProvider;

/**
 * Class SetsUpContainer
 *
 * @author brslv
 * @package Nanozen\App
 */
trait SetsUpContainer
{

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

}