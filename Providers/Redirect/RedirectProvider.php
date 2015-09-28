<?php

namespace Nanozen\Providers\Redirect;

use Nanozen\App\Injector;
use Nanozen\Contracts\Providers\Redirect\RedirectProviderContract;

/**
 * Class RedirectProvider
 *
 * @author brslv
 * @package Nanozen\Providers\Redirect 
 */
class RedirectProvider implements RedirectProviderContract
{

	public static function to($location)
	{
		header('Location: ' . $location);
		exit;
	}

	public static function loggedUser($location) {
		$userRepository = Injector::call('\Nanozen\Repositories\userRepository');

		if ($userRepository->hasLogged()) {
			static::to($location);
		}
	}

	public static function guests($location) 
	{
		$userRepository = Injector::call('\Nanozen\Repositories\userRepository');

		if ( ! $userRepository->hasLogged()) {
			static::to($location);
		}
	}

}