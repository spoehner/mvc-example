<?php
namespace Mvc\Model;

class User extends ModelBase
{
	public $name, $created;

	public function getSource()
	{
		return 'users';
	}

	public function beforeCreate()
	{
		$this->created = date('Y-m-d H:i:s');
	}
}

/*
CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `created` DATETIME NOT NULL,
  PRIMARY KEY (`id`));

INSERT INTO `users` (`name`,created) VALUES ('tester',now());
*/