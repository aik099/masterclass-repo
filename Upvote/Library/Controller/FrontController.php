<?php

namespace Upvote\Library\Controller;


class FrontController
{

	private $config;

	public function __construct($config)
	{
		$this->_setupConfig($config);
	}

	private function _setupConfig($config)
	{
		$this->config = $config;
	}

	public function execute()
	{
		$call = $this->_determineControllers();
		$call_class = $call['call'];
		$class = 'Upvote\\Application\\Controller\\' . ucfirst(array_shift($call_class)) . 'Controller';
		$method = array_shift($call_class);

		/** @var Controller $controller */
		$controller = new $class($this->config);

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