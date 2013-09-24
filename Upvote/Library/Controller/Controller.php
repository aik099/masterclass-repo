<?php
/**
 *
 *
 */

namespace Upvote\Library\Controller;


use Upvote\Library\Database\IDatabaseConnection;
use Upvote\Library\Model\Model;

class Controller
{

	/**
	 * Configuration.
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * Main controller model.
	 *
	 * @var Model
	 */
	protected $model;

	/**
	 * Database connection.
	 *
	 * @var IDatabaseConnection
	 */
	protected $db;

	/**
	 * Defines controller actions, that require user to be authenticated.
	 *
	 * @var array
	 */
	protected $authRequired = array();

	public function __construct(IDatabaseConnection $database, array $config)
	{
		$this->config = $config;
		$this->db = $database;

		$this->setup();
	}

	/**
	 * Sets up the controller internals.
	 *
	 * @return void
	 */
	protected function setup()
	{

	}

	/**
	 * Determines if an action requires user to be authenticated.
	 *
	 * @param string $action Action name.
	 *
	 * @return boolean
	 */
	public function checkActionPermissions($action)
	{
		if ( isset($this->authRequired[$action]) && !isset($_SESSION['AUTHENTICATED']) ) {
			header('Location: ' . $this->authRequired[$action]);
			exit;
		}

		return true;
	}

	/**
	 * Formats the date.
	 *
	 * @param integer $date Timestamp.
	 *
	 * @return string
	 */
	protected function formatDate($date)
	{
		return date('n/j/Y g:i a', strtotime($date));
	}

}
