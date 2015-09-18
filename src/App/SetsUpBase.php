<?php

namespace Nanozen\App;

/**
 * Trait SetsUpBase
 *
 * @author brslv
 * @package Nanozen\App
 */
trait SetsUpBase
{

    public function setupBase()
    {
        $this->base = new Base($this->container);
    }

}