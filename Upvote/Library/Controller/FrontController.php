<?php

namespace Upvote\Library\Controller;


use Upvote\Library\Database\IDatabaseConnection;
use Upvote\Library\Database\IDatabaseFactory;

class FrontController
{

	private $config;

	/**
	 * Database connection.
	 *
	 * @var IDatabaseConnection
	 */
	protected $db;

	public function __construct(IDatabaseFactory $database_factory, array $config)
	{
		$this->_setupConfig($config);
		$this->_setupDatabase($database_factory);
	}

	private function _setupConfig($config)
	{
		$this->config = $config;
	}

	/**
	 * Sets up the database.
	 *
	 * @param IDatabaseFactory $database_factory
	 *
	 * @return void
	 */
	private function _setupDatabase(IDatabaseFactory $database_factory)
	{
		$this->db = $database_factory->getConnection($this->config['database']);
	}

	public function execute()
	{
		$call = $this->_determineControllers();
		$call_class = $call['call'];
		$class = 'Upvote\\Application\\Controller\\' . ucfirst(array_shift($call_class)) . 'Controller';
		$method = array_shift($call_class);

		/** @var Controller $controller */
		$controller = new $class($this->db, $this->config);

		if ( !$controller->checkActionPermissions($method) ) {
			die('not auth');
			header("Location: /");
			exit;
		}

		return $controller->$method();
	}

	private function _determineControllers()
	{
		if ( isset($_SERVER['REDIRECT_BASE']) ) {
			$rb = $_SERVER['REDIRECT_BASE'];
		}
		else {
			$rb = '';
		}

		$ruri = $_SERVER['REQUEST_URI'];
		$path = str_replace($rb, '', $ruri);
		$return = array();

		foreach ( $this->config['routes'] as $k => $v ) {
			$matches = array();
			$pattern = '$' . $k . '$';

			if ( preg_match($pattern, $path, $matches) ) {
				$controller_details = $v;
				$path_string = array_shift($matches);
				$arguments = $matches;
				$controller_method = explode('/', $controller_details);
				$return = array('call' => $controller_method);
			}
		}

		return $return;
	}

}