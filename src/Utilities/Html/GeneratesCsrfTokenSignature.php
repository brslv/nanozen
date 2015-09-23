<?php

namespace Nanozen\Utilities\Html;

/**
 * Trait GeneratesCsrfTokenSignature
 *
 * @author brslv
 * @package Nanozen\Utilities\Html
 */
trait GeneratesCsrfTokenSignature
{

	public static function generateCsrfTokenField()
	{
		return static::hidden('csrf_token', Form::csrfToken());
	}
	
}