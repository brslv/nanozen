<?php

namespace Nanozen\Utilities\Html;

use Nanozen\Contracts\Utilities\Html\FormBuilderContract;

/**
* Class FormBuilder
*
* @author brsv
* @package Nanozen\Utilities\Html
*/
class FormBuilder implements FormBuilderContract
{

	use PutsAttributes;
	use CanGenerateHiddenField;
	use GeneratesCsrfTokenSignature;
	use GeneratesHttpMethodSignature;

	public static function build($action, $method, array $attributes = null) 
	{
		$method = strtoupper($method);
		$form = sprintf('<form action="%s" method="POST"', $action);
		
		static::putAttributes($attributes, $form);

		$form .= '>';

		if (is_null($method)) {
			$method = 'POST';
		} elseif ($method != 'POST') {
			$form .= static::generateHttpMethodSignature($method);
		}

		$form .= static::generateCsrfTokenField();

		return $form;
	}

}