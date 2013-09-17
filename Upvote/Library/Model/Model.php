<?php
/**
 *
 *
 */

namespace Upvote\Library\Model;

class Model
{

	/**
	 * Database connection.
	 *
	 * @var \PDO
	 */
	protected $db;

	/**
	 * Configuration.
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * Creates model instance.
	 *
	 * @param array $config Configuration.
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
		$this->connectToDatabase();
	}

	/**
	 * Establishes connection to database.
	 *
	 * @return void
	 */
	protected function connectToDatabase()
	{
		$db_config = $this->config['database'];
		$dsn = 'mysql:host=' . $db_config['host'] . ';dbname=' . $db_config['name'];

		$this->db = new \PDO($dsn, $db_config['user'], $db_config['pass']);
		$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}

}
