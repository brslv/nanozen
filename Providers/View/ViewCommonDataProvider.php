<?php

namespace Nanozen\Providers\View;

use Nanozen\App\Injector;

/**
 * Class ViewCommonDataProvider
 * 
 * @author brslv
 * @package Nanozen\Providers\View
 */
class ViewCommonDataProvider
{
	
	use FetchesViewCommonDataProviderDependencies;
	
	protected $commonData;
	
	public function getCommonData()
	{
		// Invoke your methods bellow:
		// e.g: $this->users();
		
		// Return logic, nothing fancy, leave it as is:
		if (is_null($this->commonData)) {
			return [];
		}
		
		return $this->commonData;
	}
	
	public function setCommonData(array $data)
	{
		$this->commonData = $data;
		
		return $this;
	}
	
	/**
	 * Below you can provide some methods to
	 * populate the common data array.
	 * 
	 * Remember - this array is then passed to all the views,
	 * so each thing you put in it,
	 * will be available 
	 * in each view.
	 * 
	 * In this class you can freely use
	 * 		- db() 		-> to access the database
	 * 		- config() 	-> to access the currently active config array
	 *  
	 * =============================================================== 
	 * ---------------------------------------------------------------
	 * Example:
	 * ---------------------------------------------------------------
	 * ===============================================================
	 * 
	 *  private function users() 
	 *	{
	 *		$users = $this->db()->query("SELECT * FROM users");
	 *		
	 *		$this->commonData['users'] = $users;
	 *	}
	 */
	
}