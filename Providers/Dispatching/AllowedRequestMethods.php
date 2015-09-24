<?php

namespace Nanozen\Providers\Dispatching;

/**
 * Trait AllowedRequestMethods
 *
 * @author brslv
 * @package Nanozen\Providers\Dispatching 
 */
trait AllowedRequestMethods 
{
	
    protected $allowedRequestMethods = ['get', 'post', 'patch', 'put', 'delete'];

}