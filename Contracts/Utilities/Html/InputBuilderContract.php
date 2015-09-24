<?php

namespace Nanozen\Contracts\Utilities\Html;

/**
 * Interface InputBuilderContract
 *
 * @author brslv
 * @package Nanozen\Contracts\Utilities\Html
 */
interface InputBuilderContract
{
	
	static function build($type, $name = null, $value = null, array $attributes = null, $text = null);

}