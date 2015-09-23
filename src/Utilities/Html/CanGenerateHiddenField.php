<?php

namespace Nanozen\Utilities\Html;

/**
 * Trait CanGenerateHiddenField
 *
 * @author brslv
 * @package Nanozen\Utilities\Html
 */
trait CanGenerateHiddenField
{

	public static function hidden($name, $value, array $attributes = null)
	{
		return InputBuilder::build('hidden', $name, $value);
	}
	
}