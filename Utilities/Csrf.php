<?php

namespace Nanozen\Utilities;

use Nanozen\Providers\Session\SessionProvider as Session;

/**
* Class Csrf
*
* @author brslv
* @package Nanozen\Utilities
*/
class Csrf
{

	public static function generate()
	{
		//$token = md5(uniqid(mt_rand(), true));
		$token = base64_encode(openssl_random_pseudo_bytes(32));
		return Session::put('_token', $token);
	}

	public static function validate($token) 
	{
		if (Session::has('_token')) {
			return Session::get('_token') == $token; 
		}
	}

}