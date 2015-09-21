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

    use SetsUpInjector;
    use SetsUpRoutes;
   
    public function __construct()
    {
        $this->setupInjector();
        $this->run();
    }

    public function run()
    {	
    	// Getting an instance of CustomRoutingProvider.
    	$router = Injector::call('\Nanozen\Providers\CustomRouting\CustomRoutingProvider');
    	
    	// Setting up the routes.
		$this->setupRoutes($router);

        // Invoking the router.
        $router->invoke();
    }

}