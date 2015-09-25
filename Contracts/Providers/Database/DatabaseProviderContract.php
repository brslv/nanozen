<?php

namespace Nanozen\Contracts\Providers\Database;

/**
 * Interface DatabaseProviderContract
 * 
 * @author brslv
 * @package Nanozen\Contracts\Providers\Database
 */
interface DatabaseProviderContract
{
	
	function query($query);
	
	function prepare($statement, array $options = []);
	
	function execute(array $parameters = []);
	
	function fetch($fetchStyle, $all = true);
	
}