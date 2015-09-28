<?php

namespace Nanozen\Providers\Session;

use Nanozen\Contracts\Providers\Session\SessionProviderContract;

/**
 * Class SessionProvider
 *
 * @author brslv
 * @package  Nanozen\Providers\Session
 */
class SessionProvider implements SessionProviderContract
{
	
	public static function put($key, $value)
	{
		$_SESSION[$key]	= $value;

		return $_SESSION[$key];
	}

	public static function get($key = null)
	{
		if (is_null($key)) {
			return $_SESSION;
		}

		if ( ! isset($_SESSION[$key]))
		{
			return false;
		}

		return $_SESSION[$key];
	}

	public static function remove($key)
	{
		if (isset($_SESSION[$key])) {
			unset($_SESSION[$key]);

			return self::get();
		}

		return false;
	}

	public static function has($key)
	{
		return isset($_SESSION[$key]);
	}

	public static function flash($name = null, $message = null)
	{
		if (is_null($name)) {
			return self::has('flash_messages'); // if any flash message is available.
		}

		if ( ! self::get($name)) {
			self::put($name, [$message]);
		} else {
			if ($message != '' && ! is_null($message)) {
				$_SESSION[$name][] = $message;
				return;
			}

			$session = self::get($name);
			self::remove($name);

			return $session;
		}
	}

}