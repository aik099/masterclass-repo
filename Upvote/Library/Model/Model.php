<?php
/**
 *
 *
 */

namespace Upvote\Library\Model;


use Upvote\Library\Database\IDatabaseConnection;

/**
 * @method \Mockery\Expectation shouldReceive
 */
abstract class Model
{

	/**
	 * Database connection.
	 *
	 * @var IDatabaseConnection
	 */
	protected $db;

	/**
	 * Creates model instance.
	 *
	 * @param IDatabaseConnection $database Database connection.
	 */
	public function __construct(IDatabaseConnection $database)
	{
		$this->db = $database;
	}

}
