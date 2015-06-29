<?php
namespace Mvc\Library;

class View
{
	protected $path, $controller, $action;

	public function __construct($path, $controllerName, $actionName)
	{
		$this->path       = $path;
		$this->controller = $controllerName;
		$this->action     = $actionName;
	}

	public function render()
	{
		$fileName = $this->path.DIRECTORY_SEPARATOR.$this->controller.DIRECTORY_SEPARATOR.$this->action.'.phtml';

		if (!file_exists($fileName)) {
			throw new NotFoundException();
		}

		include $fileName;
	}
} 