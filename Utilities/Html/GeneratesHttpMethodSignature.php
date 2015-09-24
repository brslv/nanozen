<?php

namespace Nanozen\Utilities\Html;

/**
 * Trait GeneratesHttpMethodSignature
 *
 * @author brslv
 * @package Nanozen\Utilities\Html
 */
trait GeneratesHttpMethodSignature
{

	public static function generateHttpMethodSignature($method)
	{
		return static::hidden('http_method', $method);
	}
	
}