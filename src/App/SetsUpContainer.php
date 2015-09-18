<?php

namespace Nanozen\App;

use Nanozen\Providers\Config\ConfigProvider;
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
        $base = $this->base;

        $this->container->share('me', function () {
            return 'Borislav, baby!';
        });

        $this->container->share('config', function () {
           return new ConfigProvider();
        });

        $this->container->register('dispatcher', function () {
            return new DispatchingProvider();
        });

        $this->container->share('router', function () use ($container, $base) {
            return new CustomRoutingProvider($container->resolve('dispatcher'), $base);
        });

        return $this;
    }

}