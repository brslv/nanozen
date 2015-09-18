<?php

namespace Nanozen\App;

/**
 * Class Container
 *
 * @author brslv
 * @package Nanozen\App
 */
class Container
{

    protected $registry = array();

    protected $shared = array();

    public function register($name, \Closure $resolve)
    {
        $this->registry[$name] = $resolve;
    }

    public function share($name, \Closure $resolve)
    {
        $this->shared[$name] = $resolve();
    }

    public function resolve($name)
    {
        if (array_key_exists($name, $this->registry))
        {
            $name = $this->registry[$name];
            return $name();
        }
        if (array_key_exists($name, $this->shared))
        {
            $instance = $this->shared[$name];
            return $instance;
        }

        throw new \Exception("{$name} does not found in the registry.");
    }

}