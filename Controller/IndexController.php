<?php
namespace Mvc\Controller;

use Mvc\Library\NotFoundException;
use Mvc\Model\User;

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

	public function showUserAction()
	{
		$uid = (int)(isset($_GET['uid']) ? $_GET['uid'] : '');

		if (!$uid) {
			throw new NotFoundException();
		}

		$user = User::findFirst($uid);

		if (!$user instanceof User) {
			throw new NotFoundException();
		}

		$this->view->setVars(['name' => $user->name]);
	}

	public function createUserAction()
	{
		$user       = new User();
		$user->name = 'tester with space';
		$user->save();

		die('ok '.$user->id);
	}

	public function updateUserAction()
	{
		$uid = (int)(isset($_GET['uid']) ? $_GET['uid'] : '');

		$user       = User::findFirst($uid);
		$user->name = 'tester updated';
		$user->save();

		die('ok');
	}
}