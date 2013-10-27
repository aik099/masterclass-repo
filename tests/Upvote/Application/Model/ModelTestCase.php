<?php
/**
 *
 *
 */

namespace tests\Upvote\Application\Model;


use Upvote\Library\Database\IDatabaseConnection;
use Mockery as m;
use Upvote\Library\Model\Model;

class ModelTestCase extends \PHPUnit_Framework_TestCase {

	/**
	 * Database connection.
	 *
	 * @var IDatabaseConnection
	 */
	protected $db;

	/**
	 * Model.
	 *
	 * @var Model
	 */
	protected $model;

	/**
	 * Model class.
	 *
	 * @var string
	 */
	protected $modelClass = '';

	/**
	 * Creates database connection.
	 *
	 * @return void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->db = m::mock('\\Upvote\\Library\\Database\\IDatabaseConnection');

		$model_class = $this->modelClass;
		$this->model = new $model_class($this->db);
	}

}
