<?php
/**
 *
 *
 */

namespace Upvote\Library\Controller;


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
	 * Defines controller actions, that require user to be authenticated.
	 *
	 * @var array
	 */
	protected $authRequired = array();

	public function __construct($config)
	{
		$this->config = $config;
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

}
