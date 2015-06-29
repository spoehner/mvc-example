<?php
namespace Mvc\Model;

class User extends ModelBase
{
	public $id, $name, $created;

	public function getSource()
	{
		return 'users';
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