<?php

namespace Nanozen\Providers\Database\Drivers;

use Nanozen\Providers\Database\Drivers\MySql;

/**
 * Class DatabaseFactory
 * 
 * @author brslv
 * @package Nanozen\Providers\Database\Drivers
 */
class DatabaseFactory
{
	
	const DEFAULT_DRIVER = 'mysql';
	
	public static function make($host, $dbName, $driver = null)
	{	
		// dns strings
		$mysqlDns = (new MySql($host, $dbName))->getDsn();
		
		// make
		switch ($driver) {
			case 'mysql': 
				return $mysqlDns;
			default:
				return $mysqlDns;
		}
	}
	
}