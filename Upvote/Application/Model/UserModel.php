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
		$fields_hash = array(
			'username' => $username,
			'email' => $email,
			'password' => $this->hashPassword($username, $password)
		);

		return $this->db->insert($fields_hash, 'user');
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
		$fields_hash = array(
			'password' => $this->hashPassword($username, $new_password),
		);

		$this->db->update($fields_hash, 'user', 'username = ?', array($username));
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
				WHERE username = ? AND password = ?';

		$params = array(
			$username,
			$this->hashPassword($username, $password)
		);

		$data = $this->db->fetchRow($sql, $params);

		return $data !== false;
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

		return $this->db->fetchRow($sql, array($username));
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
