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
	
	/**
	 * @var \PDO
	 */
	protected $handler;
	
	/**
	 * @var \PDOStatement
	 */
	protected $query;
	
	public function __construct($driver, $host, $dbName, $dbUser, $dbPassword, $options = null)
	{
		$dsn = DatabaseFactory::make($host, $dbName, $driver);
		$this->handler = new \PDO($dsn, $dbUser, $dbPassword, $options);
	}
	
	/**
	 * @see \Nanozen\Contracts\Providers\Database\DatabaseProviderContract::query()
	 * @return \Nanozen\Providers\Database\DatabaseProvider
	 */
	public function query($query)
	{
		$this->query = $this->handler->query($query);
		
		return $this;
	}
	
	/**
	 * @see \Nanozen\Contracts\Providers\Database\DatabaseProviderContract::prepare()
	 * @return \Nanozen\Providers\Database\DatabaseProvider
	 */
	public function prepare($statement, array $options = []) 
	{
		if (trim($statement) == "" || empty($statement)) {
			throw new \Exception("Statement cannot be empty.");
		}
		
		$this->query = $this->handler->prepare($statement);
		
		return $this;
	}
	
	/**
	 * @see \Nanozen\Contracts\Providers\Database\DatabaseProviderContract::execute()
	 * @return boolean
	 */
	public function execute(array $parameters = [])
	{
		if (is_null($this->query)) {
			throw new \Exception('Cannot invoke execute. Try using query or prepare/execute before fetch.');
		}
		
		return $this->query->execute($parameters);
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