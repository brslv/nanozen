<?php

namespace Nanozen\Utilities\Html;

use Nanozen\Utilities\Csrf;

/**
 * Class Form
 *
 * @author brslv
 * @package Nanozen\Utilities\Html
 */
class Form
{

	use PutsAttributes;
	use CanGenerateHiddenField;
	use GeneratesCsrfTokenSignature;
	use GeneratesHttpMethodSignature;

	public static function radio($name, $value, array $attributes = null, $text = null) 
	{
		if (is_null($text)) {
			$text = ucfirst($name);
		}
		
		return 
			InputBuilder::build('radio', $name, $value, $attributes, $text);
	}

	public static function checkbox($name, $value, array $attributes = null, $text = null)
	{
		if (is_null($text)) {
			$text = ucfirst($name);
		}

		return 
			InputBuilder::build('checkbox', $name, $value, $attributes, $text);
	}

	public static function text($name, array $attributes = null)
	{
		return InputBuilder::build('text', $name, null, $attributes);
	}

	public static function email($name, array $attributes = null)
	{
		return InputBuilder::build('email', $name, null, $attributes);
	}

	public static function input($name, array $attributes = null)
	{
		return InputBuilder::build($name, null, $attributes);
	}

	public static function submit($name, array $attributes = null)
	{
		return InputBuilder::build('submit', $name, null, $attributes);
	}	

	public static function password($name, array $attributes = null)
	{
		return InputBuilder::build('password', $name, null, $attributes);
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

	public static function textarea($name, array $attributes = null)
	{
		$textarea = sprintf('<textarea name="%s"', $name);

		static::putAttributes($attributes, $textarea);

		$textarea .= '></textarea>';

		return $textarea;
	}

	public static function csrfToken()
	{
		return Csrf::generate();
	}

	public static function start($action, $method = null, array $attributes = null)
	{
		return FormBuilder::build($action, $method, $attributes);
	}

	public static function stop()
	{
		return '</form>';
	}

}