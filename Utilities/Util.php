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
		if ( ! is_object($something) && ! is_array($something)) {
			return htmlspecialchars($something, ENT_QUOTES, 'UTF-8');
		}
		
		if (is_array($something)) {
			static::eArray($something);
		}

		return $something;
	}
	
	private static function eArray(&$variable) 
	{
		foreach ($variable as &$value) {
			if ( ! is_array($value) && ! is_object($value)) { 
				$value = htmlspecialchars($value); 
			} else { 
				static::eArray($value); 
			}
		}
	}
	
}