<?php

namespace Nanozen\Providers\CustomRouting;

/**
 * Trait AddsRoutes
 *
 * @author brslv
 * @package Nanozen\Providers\CustomRouting
 */
trait AddsRoutes
{

    protected $forArea = null;

    public function get($route, $target)
    {
        if ( ! is_null($this->forArea)) {
            $this->areas[$this->forArea]['routes']['get'][$route] = $target;
            $this->forArea = null;
            return;
        }

        $this->routes['get'][$route] = $target;
    }

    public function post($route, $target)
    {
        if ( ! is_null($this->forArea)) {
            $this->areas[$this->forArea]['routes']['post'][$route] = $target;
            $this->forArea = null;
            return;
        }

        $this->routes['post'][$route] = $target;
    }

    public function patch($route, $target)
    {
        if ( ! is_null($this->forArea)) {
            $this->areas[$this->forArea]['routes']['patch'][$route] = $target;
            $this->forArea = null;
            return;
        }

        $this->routes['patch'][$route] = $target;
    }

    public function put($route, $target)
    {
        if ( ! is_null($this->forArea)) {
            $this->areas[$this->forArea]['routes']['put'][$route] = $target;
            $this->forArea = null;
            return;
        }

        $this->routes['put'][$route] = $target;
    }

    public function delete($route, $target)
    {
        if ( ! is_null($this->forArea)) {
            $this->areas[$this->forArea]['routes']['delete'][$route] = $target;
            $this->forArea = null;
            return;
        }

        $this->routes['delete'][$route] = $target;
    }

    // Areas - TODO: refactor
    
    public function area($routePrefix, $areaFolder) 
    {
        $this->areas[$routePrefix]['folder'] = $areaFolder;
        $this->areas[$routePrefix]['routes'] = [
            'get' => [],
            'post' => [],
        ];
    }

    public function forArea($routePrefix) 
    {
        $this->forArea = $routePrefix;

        return $this;
    }
    
}