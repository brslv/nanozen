<?php

namespace Nanozen\Utilities\Html;

/**
 * Class Form
 *
 * @author brslv
 * @package Nanozen\Utilities\Html
 */
class Form
{

	public static function radio($name, $value, array $attributes = null, $text = null) 
	{
		return 
			static::simpleInput('radio', $name, $value, $attributes, $text);
	}

	protected static function simpleInput($type, $name, $value, array $attributes = null, $text = null) 
	{
		if (is_null($text)) {
			$text = ucfirst($name);
		}

		$input = sprintf('<input type="%s" name="%s" value="%s"', $type, $name, $value);

		if ( ! empty($attributes) && ! is_null($attributes)) {
			foreach ($attributes as $attrName => $attrValue) {
				$input .= sprintf(' %s="%s"', $attrName, $attrValue);
			}
		}
		$input .= sprintf(' /> %s ', $text);
		return $input;
	}

	public static function check($name, $value, array $attributes = null, $text = null)
	{
		return 
			static::simpleInput('checkbox', $name, $value, $attributes, $text);
	}

}