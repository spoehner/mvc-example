<?php
namespace Mvc\Model;

abstract class ModelBase
{
	private static $pdo;

	/**
	 * Get the connection. This will open a connection, if does not exist yet.
	 *
	 * @return \PDO
	 */
	public function getPdo()
	{
		if (self::$pdo === null) {
			self::$pdo = new \PDO('mysql:host=localhost;dbname=mvc-example', 'root', '123');
		}

		return self::$pdo;
	}

	/**
	 * @param int|array $options
	 *
	 * @return static
	 */
	public static function findFirst($options)
	{
		$model = new static();
		$table = $model->getSource();
		/** @var \PDO $pdo */
		$pdo = $model->getPdo();

		if (is_int($options)) {
			// we are looking for an ID
			$stmt = $pdo->prepare('SELECT * FROM `'.$table.'` WHERE id = ? LIMIT 1');
			$stmt->execute([$options]);
		} elseif (is_array($options) && isset($options['criteria'])) {
			$stmt = $pdo->prepare('SELECT * FROM `'.$table.'` WHERE '.$options['criteria'].' LIMIT 1');
			$stmt->execute($options['bind']);
		} else {
			throw new \UnexpectedValueException('you need to specify the criteria');
		}

		return $stmt->fetchObject(get_class($model));
	}

	/**
	 * @param array $options
	 *
	 * @return static
	 */
	public static function find(array $options)
	{
		$model = new static();
		$table = $model->getSource();
		/** @var \PDO $pdo */
		$pdo = $model->getPdo();

		if (!isset($options['criteria'])) {
			throw new \UnexpectedValueException('you need to specify the criteria');
		}

		$stmt = $pdo->prepare('SELECT * FROM `'.$table.'` WHERE '.$options['criteria']);
		$stmt->execute($options['bind']);

		return $stmt->fetchAll(\PDO::FETCH_CLASS, get_class($model));
	}

	/**
	 * The table name of the model.
	 *
	 * @return string
	 */
	abstract public function getSource();
} 