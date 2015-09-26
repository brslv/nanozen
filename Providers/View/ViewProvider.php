<?php

namespace Nanozen\Providers\View;

use Nanozen\Contracts\Providers\View\ViewProviderContract;
use Nanozen\App\Injector;
use Nanozen\Utilities\Util;

/**
 * Class ViewProvider
 *
 * @author brslv
 * @package Nanozen\Providers\View 
 */
class ViewProvider implements ViewProviderContract 
{

	public $dependsOn = ['viewCommonDataProviderContract'];
	
	protected $data = [];

	protected $path;

	protected $view;

	protected $requiredObject = null;

	protected $viewFullName;

	protected $escapeHtmlChars = true;

	public function setPath($path)
	{
		if (trim($path) == "") {
			throw new \Exception("Invalid path {$path}");
		}

		if (substr($this->path, -1) != '/') {
			$this->path .= '/';
		}

		$this->path = $path;
	}

	public function render($view, $data = null)
	{
		echo $this->fetch($view, $data);
		exit();
	}

	public function make($view, $data = null)
	{
		return $this->fetch($view, $data);
	}

	private function fetch($view, $data = null) 
	{
		$this->view = $view;
		$this->data = is_null($data) 
			? $this->data 
				: array_merge($data, $this->data, $this->viewCommonDataProviderContract->getCommonData());
		
		extract($this->escapeData());

		if (isset($this->requiredObject) && ! is_null($this->requiredObject)) {
			if ( ! $this->matchRequiredObject()) {
				throw new \Exception("Required object not matching. This view requires {$this->requiredObject} type.");
			}
		}

		if (is_null($this->path)) {
			$this->setDefaultPath();
		}

		$rendered = "";

		if ($this->viewExists()) {
			//
			ob_start();
				require($this->viewFullName);
	        	$rendered = ob_get_contents(); 
			ob_end_clean();
			//
		} else {
			throw new \Exception("View {$this->view} does not exist.");
		}

		return $rendered;
	}
	
	private function escapeData()
	{
		if ($this->escapeHtmlChars) {
			Util::e($this->data);
		}
		
		return $this->data;
	}

	private function matchRequiredObject()
	{
		if (is_null($this->data) || empty($this->data)) {
			throw new Exception("Required object not matching. This view requires {$this->requiredObject} type.");
		}

		$requiredObject = ltrim($this->requiredObject, '\\');

		foreach ($this->data as $key => $value) {
			$class = is_object($value) ? get_class($value) : false;

			if ($class && $class == $requiredObject) {
				return true;
			} 
		}

		return false;
	}

	private function setDefaultPath()
	{
		$config = Injector::call('\Nanozen\Providers\Config\configProvider');
		$this->path = $config->get('paths.views');

		return $this;
	}

	private function viewExists()
	{
		$this->viewFullName = $this->path . str_replace('.', DIRECTORY_SEPARATOR, $this->view) . '.php';

		if (isset($this->view) && $this->view != "") {
			if (file_exists($this->viewFullName)) {
				return true;
			}	
		}

		return false;
	}

	public function escape($doEscapeThoseBitches = true)
	{
		if ( ! $doEscapeThoseBitches) {
			$this->escapeHtmlChars = false;
		}

		return $this->escapeHtmlChars;
	}

	public function uses($requiredObject)
	{
		if (trim($requiredObject) == "") {
			throw new \Exception('Invalid required object.');
		}

		$this->requiredObject = $requiredObject;

		return $this;
	}

	public function __get($property) 
	{
		if (array_key_exists($property, $this->data)) {
			return $this->data[$property];
		}

		// TODO: remove me!		
		throw new \Exception("Property {$property} does not exist.");
	}

	public function __set($property, $value) 
	{
		$this->data[$property] = $value;
	}

}