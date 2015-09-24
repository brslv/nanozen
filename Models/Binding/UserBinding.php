<?php

namespace Nanozen\Models\Binding;

/**
 * Class UserBinding
 *
 * @author brslv
 * @package Nanozen\Models\Binding 
 */
class UserBinding 
{
	public $name;
	public $age;

	public function __construct($name, $age) 
	{
		$this->name = $name;
		$this->age = $age;
	}
}