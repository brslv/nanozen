<?php

namespace Nanozen\Providers\Database;

use Nanozen\Contracts\Providers\Database\DatabaseProviderContract;
use Nanozen\Providers\Database\Drivers\DatabaseFactory;

/**
 * Class DatabaseProvider
 * 
 * @author brslv
 * @package Nanozen\Providers\Database
 */
class DatabaseProvider implements DatabaseProviderContract 
{
	
	protected $handler;
	
	public function __construct($driver, $host, $dbName, $dbUser, $dbPassword, $options = null)
	{
		$dsn = DatabaseFactory::make($host, $dbName, $driver);
		$this->handler = new \PDO($dsn, $dbUser, $dbPassword, $options);
	}
	
	public function query($query)
	{
		return $this->query($query);		
	}
	
	public function prepare($statement, array $options = []) 
	{
		
	}
	
	public function execute(array $parameters = [])
	{
		
	}
	
	public function fetch($fetchStyle, $all = true)
	{
		
	}
	
}