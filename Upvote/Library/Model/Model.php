<?php
/**
 *
 *
 */

namespace Upvote\Library\Model;


use Upvote\Library\Database\IDatabaseConnection;

class Model
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
