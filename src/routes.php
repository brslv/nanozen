<?php

/**
 * Provide routes for the app.
 * 
 */

// When this route is not available
// the routing engine will default to HomeController::index.
$router->get('/', 'HomeController@welcome'); 

$router->get('aloha/{name:a}', 'HomeController@aloha');

$router->get('bye', 'HomeController@bye');

$router->get('nice', 'TestController@nice');

// $router->get('auto', 'HomeController@automatic');