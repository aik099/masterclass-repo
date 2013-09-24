<?php
/**
 *
 *
 */

namespace Upvote\Library\Database;


class DatabaseFactory implements IDatabaseFactory
{

	/**
	 * Returns database connection by given connection details.
	 *
	 * @param array $connection_details
	 *
	 * @return IDatabaseConnection
	 */
	public function getConnection(array $connection_details)
	{
		return new DatabaseAdapter($connection_details);
	}

}
