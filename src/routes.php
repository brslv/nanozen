<?php

/**
 * Provide routes for the app.
 * 
 */
// Example for adding custom patterns.
// The alias should start with :.
// The pattern should use #.
// $router->addPattern(':c', '#[c]#');

// When this route is not available
// the routing engine will default to HomeController::index.

$router->get('/', 'HomeController@welcome'); 

$router->get('aloha/{name:s}', 'HomeController@aloha');

$router->get('bye', 'HomeController@bye');

$router->get('nice', 'TestController@nice');

$router->area('forum', 'Forum'); // forum is the area's url prefix; Forum is the area's folder.

$router->forArea('forum')->get('topics', 'TopicsController@index'); // adds new route for the forum area.

// When this route is available
// it will override the default behaviour
// of HomeController::automatic action and will be called on route /auto instead.
// $router->get('auto', 'HomeController@automatic');