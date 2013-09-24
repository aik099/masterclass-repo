<?php
/**
 *
 *
 */

namespace Upvote\Library\Database;


interface IDatabaseTransactionAware
{

	/**
	 * Begin a database transaction.
	 *
	 * @return void
	 */
	public function beginTransaction();

	/**
	 * Commit a database transaction.
	 *
	 * @return void
	 */
	public function commit();

	/**
	 * Roll back a database transaction.
	 */
	public function rollback();

}
