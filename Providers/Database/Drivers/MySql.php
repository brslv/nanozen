<?php

namespace Nanozen\Providers\Database\Drivers;

/**
 * Class MySql
 * 
 * @author brslv
 * @package Nanozen\Providers\Database\Drivers;
 */
class MySql
{
	
	private $dsn;
	
	public function __construct($host, $dbName)
	{
		$this->dsn = sprintf('mysql:host=%s;dbname=%s', $host, $dbName);
		
	}
	
	public function getDsn()
	{
		return $this->dsn;
	}
	
}