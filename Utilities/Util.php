<?php

namespace Nanozen\Utilities;

/**
 * Class Util
 *
 * @author brslv
 * @package Nanozen\Utilities
 */
class Util 
{

	/**
	 * Escapes strings for presentation.
	 *
	 * @param string $something Something to be escaped
	 * @return string
	 */
	public static function e($something)
	{
		if ( ! is_object($something)) {
			return htmlspecialchars($something, ENT_QUOTES, 'UTF-8');
		}

		return $something;
	}
	
}