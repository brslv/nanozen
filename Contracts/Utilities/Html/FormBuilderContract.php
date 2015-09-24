<?php

namespace Nanozen\Contracts\Utilities\Html;

/**
 * Interface FormBuilderContract
 *
 * @author brslv
 * @package Nanozen\Contracts\Utilities\Html
 */
interface FormBuilderContract
{
	
	static function build($action, $method, array $attributes = null);

}