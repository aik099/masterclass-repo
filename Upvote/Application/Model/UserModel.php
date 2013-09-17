<?php

namespace Upvote\Application\Model;


use Upvote\Library\Model\Model;

class UserModel extends Model
{

	/**
	 * Creates user.
	 *
	 * @param string $username Username.
	 * @param string $email    Email.
	 * @param string $password Password.
	 *
	 * @return integer
	 */
	public function create($username, $email, $password)
	{
		$sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
		$stmt = $this->db->prepare($sql);

		$params = array(
			$username,
			$email,
			$this->hashPassword($username, $password)
		);

		$stmt->execute($params);

		return $this->db->lastInsertId();
	}

	/**
	 * Changes user password.
	 *
	 * @param string $username     Username.
	 * @param string $new_password New password.
	 *
	 * @return void
	 */
	public function changePassword($username, $new_password)
	{
		$sql = 'UPDATE user
				SET password = ?
				WHERE username = ?';
		$stmt = $this->db->prepare($sql);

		$params = array(
			$this->hashPassword($username, $new_password),
			$username,
		);

		$stmt->execute($params);
	}

	/**
	 * Verifies, that user with given credentials exists.
	 *
	 * @param string $username Username.
	 * @param string $password Password.
	 *
	 * @return boolean
	 */
	public function verifyCredentials($username, $password)
	{
		$sql = 'SELECT *
				FROM user
				WHERE username = ? AND password = ? LIMIT 1';
		$stmt = $this->db->prepare($sql);

		$params = array(
			$username,
			$this->hashPassword($username, $password)
		);

		$stmt->execute($params);

		return $stmt->rowCount() > 0;
	}

	/**
	 * Searches for user in database.
	 *
	 * @param string $username Username.
	 *
	 * @return array
	 */
	public function lookup($username)
	{
		$sql = 'SELECT *
				FROM user
				WHERE username = ?';
		$stmt = $this->db->prepare($sql);

		$stmt->execute(array($username));

		return $stmt->rowCount() ? $stmt->fetch(\PDO::FETCH_ASSOC) : array();
	}

	/**
	 * Creates password hash.
	 *
	 * @param string $username Username.
	 * @param string $password Password.
	 *
	 * @return string
	 */
	protected function hashPassword($username, $password)
	{
		// THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
		return md5($username . $password);
	}

}
