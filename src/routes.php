<?php

/**
 * Provide routes for the app.
 * 
 */

// Setting routes.
$route->get('/', 'HomeController@welcome');

// If you want to use the container inside the closure
// pass $base to it.
$route->get('/closure', function ($base) {
	echo $base->container->resolve('me');
});

$route->get('aloha/{name:a}', 'HomeController@aloha');

$route->get('bye', 'HomeController@bye');