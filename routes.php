<?php

/**
 * A journey of a thousand miles begins with a single step.
 * Give me the first step of the journey, master.
 */

$router->get('/', 'HomeController@welcome');

$router->get('strong', 'HomeController@testsStrongView');

$router->get('form', 'HomeController@form');

$router->put('process', 'HomeController@process');

$router->area('test', 'TestArea');

$router->forArea('test')->get('something', 'HomeController@test');