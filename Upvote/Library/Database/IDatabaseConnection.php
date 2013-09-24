<?php
/**
 *
 *
 */

namespace Upvote\Library\Database;


interface IDatabaseConnection
{

	/**
	 * Fetch an associative array of one result.
	 *
	 * @param string $sql  Database query.
	 * @param array  $args Query arguments.
	 *
	 * @return string
	 */
	public function fetchRow($sql, array $args = array());

	/**
	 * Fetch an array of associative arrays of ALL results.
	 *
	 * @param string $sql  Database query.
	 * @param array  $args Query arguments.
	 *
	 * @return array
	 */
	public function fetchAll($sql, array $args = array());

	/**
	 * Inserts new record to database and returns it's id.
	 *
	 * @param array  $fields_hash Fields hash.
	 * @param string $table       Table name.
	 *
	 * @return integer
	 */
	public function insert(array $fields_hash, $table);

	/**
	 * Updates existing record to database.
	 *
	 * @param array  $fields_hash  Fields hash.
	 * @param string $table        Table name.
	 * @param string $where_clause Where clause.
	 * @param array  $args         Arguments.
	 *
	 * @return void
	 */
	public function update(array $fields_hash, $table, $where_clause, $args = array());

}
