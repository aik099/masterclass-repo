<?php
/**
 *
 *
 */

namespace Upvote\Library\Database;


class DatabaseAdapter implements IDatabaseConnection
{

	/**
	 * Database connection.
	 *
	 * @var \PDO
	 */
	protected $connection;

	/**
	 * Creates database connection.
	 *
	 * @param array $config Database configuration.
	 */
	public function __construct($config)
	{
		$dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['name'];

		$this->connection = new \PDO($dsn, $config['user'], $config['pass']);
		$this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * Fetch an associative array of one result.
	 *
	 * @param string $sql  Database query.
	 * @param array  $args Query arguments.
	 *
	 * @return string
	 * @throws DatabaseException When database error occurs.
	 */
	public function fetchRow($sql, array $args = array())
	{
		$sql .= ' LIMIT 1';

		return $this->prepareStatement($sql, $args)->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Fetch an array of associative arrays of ALL results.
	 *
	 * @param string $sql  Database query.
	 * @param array  $args Query arguments.
	 *
	 * @return array
	 */
	public function fetchAll($sql, array $args = array())
	{
		return $this->prepareStatement($sql, $args)->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * Inserts new record to database and returns it's id.
	 *
	 * @param array  $fields_hash Fields hash.
	 * @param string $table       Table name.
	 *
	 * @return integer
	 */
	public function insert(array $fields_hash, $table)
	{
		$fields_string = implode(', ', array_keys($fields_hash));
		$values_string = substr(str_repeat('?, ', count($fields_hash)), 0, -2);

		$sql = 'INSERT INTO ' . $table . ' (' . $fields_string . ') VALUES (' . $values_string . ')';
		$this->prepareStatement($sql, array_values($fields_hash));

		return $this->connection->lastInsertId();
	}

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
	public function update(array $fields_hash, $table, $where_clause, $args = array())
	{
		$values_string = implode(' = ?, ', array_keys($fields_hash)) . ' = ?';

		$sql = 'UPDATE ' . $table . '
				SET ' . $values_string . '
				WHERE ' . $where_clause;
		$this->prepareStatement($sql, array_merge(array_values($fields_hash), $args));
	}

	/**
	 * Prepares statement.
	 *
	 * @param string $sql  Database query.
	 * @param array  $args Query arguments.
	 *
	 * @return \PDOStatement
	 * @throws DatabaseException When database error occurs.
	 */
	protected function prepareStatement($sql, array $args = array())
	{
		try {
			$stmt = $this->connection->prepare($sql);
			$stmt->execute($args);
		}
		catch (\PDOException $e) {
			$error_info = $this->connection->errorInfo();

			throw new DatabaseException($error_info[2], $error_info[1]);
		}

		return $stmt;
	}

}
