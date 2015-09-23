<?php

namespace Nanozen\Utilities\Html;

use Nanozen\Contracts\Utilities\Html\InputBuilderContract;

/**
* Class InputBuilder
*
* @author brslv
* @package Nanozen\Utilities\Html
*/
class InputBuilder implements InputBuilderContract
{

	use PutsAttributes;
	use CanGenerateHiddenField;
	use GeneratesCsrfTokenSignature;
	use GeneratesHttpMethodSignature;

	public static function build($type, $name = null, $value = null, array $attributes = null, $text = null) 
	{
		$input = sprintf('<input type="%s"', $type);

		if ( ! is_null($name)) {
			$input .= sprintf(' name="%s"', $name);
		}

		if ( ! is_null($value)) {
			$input .= sprintf(' value="%s"', $value);
		}

		static::putAttributes($attributes, $input);

		if ( ! is_null($text)) {
			$input .= sprintf(' /> %s ', $text);
		} else {
			$input .= sprintf(' />');
		}

		return $input;
	}

}