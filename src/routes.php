<?php

/**
 * Provide routes for the app.
 * 
 */

$router->get('/', 'HomeController@welcome');

$router->get('aloha/{name:a}', 'HomeController@aloha');

$router->get('bye', 'HomeController@bye');

$router->get('nice', 'TestController@nice');