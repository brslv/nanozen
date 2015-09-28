<?php

namespace Nanozen\Utilities;

/**
* Class Hash
*
* @author brslv
* @package Nanozen\Utilities
*/
class Hash 
{

	public static function password($password)
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}

	public static function verifyPassword($password, $hash) 
	{
		return password_verify($password, $hash);	
	}

}