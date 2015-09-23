<?php

namespace Nanozen\Utilities\Html;

/**
 * Trait PutsAttributes
 *
 * @author brslv
 * @package Nanozen\Utilities\Html
 */
trait PutsAttributes
{

	protected static function putAttributes($attributes, &$elementStringRepresentation)
	{
		if ( ! empty($attributes) && ! is_null($attributes)) {
			foreach ($attributes as $attrName => $attrValue) {
				$elementStringRepresentation .= sprintf(' %s="%s"', $attrName, $attrValue);
			}
		}

		return $elementStringRepresentation;
	}
	
}