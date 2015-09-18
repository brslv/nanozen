<?php

namespace Nanozen\App;

/**
 * Class Base
 *
 * @author brslv
 * @package Nanozen\App
 */
class Base
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return false;
    }

}