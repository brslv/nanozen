<?php

namespace Nanozen\App;

/**
 * Class Boot
 *
 * @author brslv
 * @package Nanozen\App
 */
class Boot
{

    use SetsUpContainer;
    use SetsUpRoutes;
    use SetsUpBase;

    protected $container;

    protected $base;

    public function __construct()
    {
        $this->setupContainer();
        $this->setupBase();
        $this->populateContainer();
        $this->run();
    }

    public function run()
    {
        $this->setupRoutes();

        // Invoking the router.
        $this->container->resolve('router')->invoke();
    }

}