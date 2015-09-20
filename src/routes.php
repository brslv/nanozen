<?php

/**
 * Provide routes for the app.
 * 
 */

$route->get('/', 'HomeController@welcome');

$route->get('/closure', function ($base) {
	echo $base->container->resolve('me');
});

$route->get('aloha/{name:a}', 'HomeController@aloha');

$route->get('bye', 'HomeController@bye');