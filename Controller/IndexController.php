<?php
namespace Mvc\Controller;

class IndexController implements Controller
{
	/** @var \Mvc\Library\View */
	protected $view;

	public function setView(\Mvc\Library\View $view)
	{
		$this->view = $view;
	}

	public function indexAction()
	{
		$this->view->setVars([
			'name' => 'Stefan',
		]);
	}
}