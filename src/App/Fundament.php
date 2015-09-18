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

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

}