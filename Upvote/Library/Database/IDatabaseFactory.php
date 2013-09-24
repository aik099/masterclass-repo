<?php
/**
 *
 *
 */

namespace Upvote\Library\Database;


interface IDatabaseFactory
{

	/**
	 * Returns database connection by given connection details.
	 *
	 * @param array $connection_details
	 *
	 * @return IDatabaseConnection
	 */
	public function getConnection(array $connection_details);

}
