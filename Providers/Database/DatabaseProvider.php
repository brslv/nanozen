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
	
	protected $query;
	
	public function __construct($driver, $host, $dbName, $dbUser, $dbPassword, $options = null)
	{
		$dsn = DatabaseFactory::make($host, $dbName, $driver);
		$this->handler = new \PDO($dsn, $dbUser, $dbPassword, $options);
	}
	
	public function query($query)
	{
		$this->query = $this->handler->query($query);
		
		return $this;
	}
	
	public function prepare($statement, array $options = []) 
	{
		
	}
	
	public function execute(array $parameters = [])
	{
		
	}
	
	public function fetch($fetchStyle = null, $all = true)
	{
		if (is_null($this->query)) {
			throw new \Exception('Cannot invoke fetch. Try using query or prepare/execute before fetch.');
		}
		
		if (is_null($fetchStyle)) {
			$fetchStyle = \PDO::FETCH_OBJ;
		}
		
		if ($all === true) {
			return $this->query->fetchAll($fetchStyle);
		}
		
		return $this->query->fetch($fetchStyle);
	}
	
}