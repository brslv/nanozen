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

		static::putAttributes($attributes, $input);

		$input .= sprintf(' /> %s ', $text);
		return $input;
	}

	protected static function putAttributes($attributes, &$elementStringRepresentation)
	{
		if ( ! empty($attributes) && ! is_null($attributes)) {
			foreach ($attributes as $attrName => $attrValue) {
				$elementStringRepresentation .= sprintf(' %s="%s"', $attrName, $attrValue);
			}
		}

		return $elementStringRepresentation;
	}

	public static function check($name, $value, array $attributes = null, $text = null)
	{
		return 
			static::simpleInput('checkbox', $name, $value, $attributes, $text);
	}

	public static function dropdown($name, array $options, array $attributes = null)
	{
		$dropdown = sprintf('<select');
		
		static::putAttributes($attributes, $dropdown);

		$dropdown .= '>';

		if (empty($options)) {
			return false;
		}

		foreach ($options as $optionValue => $optionText) {
			$dropdown .= sprintf('<option value="%s"> %s ', $optionValue, $optionText);
		}

		$dropdown .= "</select>";

		return $dropdown;	
	}

}