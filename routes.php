<?php

/**
 * A journey of a thousand miles begins with a single step.
 * Give me the first step of the journey, master.
 */

// Some usefull instructions:

// Pattens:
// Example for adding custom patterns.
// The alias should start with :.
// The pattern should use #.
// E.g.: $router->addPattern(':c', '#[c]#');

// Areas:
// This simple line activates the routing for areas.
// 		$router->area('test', 'TestArea');
// By default, the routing is automatic (mapping automatic controller/action/params).
// Can be customized by:
// 		$router->forArea('test')->get('some-route', 'SomeController@action');

$router->get('/', 'HomeController@welcome');

$router->get('/form', 'HomeController@form');

$router->put('/process', 'HomeController@process');