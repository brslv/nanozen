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
		return Session::put('csrf_token', $token);
	}

	public static function validate($token) 
	{
		if (Session::has('csrf_token')) {
			return Session::get('csrf_token') == $token; 
		}
	}

}