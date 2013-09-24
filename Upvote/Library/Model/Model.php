<?php
/**
 *
 *
 */

namespace Upvote\Library\Model;

use Upvote\Library\Database\IDatabaseConnection;
use Upvote\Library\Database\IDatabaseFactory;

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
	 * @param IDatabaseFactory $database_factory Database factory.
	 * @param array            $config           Configuration.
	 */
	public function __construct(IDatabaseFactory $database_factory, array $config = array())
	{
		$this->db = $database_factory->getConnection($config['database']);
	}

}
