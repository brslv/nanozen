<?php

namespace Nanozen\Utilities;

/**
 * Class Escpr
 *
 * @author brslv
 * @package Nanozen\Escpr
 */
class Escpr 
{

	/**
	 * Escapes a given thing.
	 *
	 * @param mixed $thisThing The thing to escape. 
	 *                         Can be anything you think of - 
	 *                         string, array, objects, 
	 *                         array of objects...anything.
	 */
	public static function escape(&$thisThing) 
	{
		if (is_string($thisThing)) {
			htmlspecialchars($thisThing);
			return;
		}

		if (is_array($thisThing)) {
			self::escapeArray($thisThing);
		}

		if (is_object($thisThing) && ! is_array($thisThing)) {
			self::escapeObject($thisThing);
		}

		return $thisThing;
	}

	/**
	 * Escapes arrays.
	 * 
	 * @param array &$arr The array to be escaped.
	 */
	public static function escapeArray(&$arr) 
	{
		foreach ($arr as $key => &$value) {

			if (is_array($value)) {
				// If the current element is array: 
				
				self::escape($value);
			} elseif (is_object($value) && ! is_array($value)) {
				self::escapeObject($value);
			} else {
				$value = htmlspecialchars($value);	
			}
		}
	}

	/**
	 * Escapes objects.
	 * 
	 * @param mixed &$obj The object to be escaped.
	 */
	public static function escapeObject(&$obj)
	{	
		$reflector = new \ReflectionClass($obj);
		$properties = $reflector->getProperties();

		foreach ($properties as $property) {
			$property->setAccessible(true);
			$propertyValue = $property->getValue($obj);

			if (is_array($propertyValue)) {
				$property->setValue($obj, self::escape($propertyValue));
			} else {
				$property->setValue($obj, htmlspecialchars($propertyValue));
			}
		}
	}
	
}