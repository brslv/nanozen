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

	protected $data = [];

	protected $path;

	protected $view;

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
				: array_merge($data, $this->data);

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
		}

		return $rendered;
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

	public function __get($property) 
	{
		if (array_key_exists($property, $this->data)) {
			return $this->escapeHtmlChars 
				? Util::e($this->data[$property])
					: $this->data[$property];
		}

		// TODO: remove me!		
		throw new \Exception("Property {$property} does not exist.");
	}

	public function __set($property, $value) 
	{
		$this->data[$property] = $value;
	}

}