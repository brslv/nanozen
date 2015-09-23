<?php

namespace Nanozen\Contracts\Providers\Session;

/**
 * Interface SessionProviderContract
 *
 * @author brslv
 * @package Nanozen\Contracts\Providers\Session
 */
interface SessionProviderContract
{

	static function put($key, $value);

	static function get($key = null);
	
	static function remove($key);

	static function has($key);

}