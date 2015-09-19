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

    protected static $registry = array();

    protected static $shared = array();

    public static function register($name, \Closure $resolve)
    {
        static::$registry[$name] = $resolve;
    }

    public function share($name, \Closure $resolve)
    {
        static::$shared[$name] = $resolve();
    }

    public function resolve($name)
    {
        if (array_key_exists($name, static::$registry))
        {
            $name = static::$registry[$name];
            return $name();
        }
        if (array_key_exists($name, static::$shared))
        {
            $instance = static::$shared[$name];
            return $instance;
        }

        throw new \Exception("{$name} does not found in the registry.");
    }

}