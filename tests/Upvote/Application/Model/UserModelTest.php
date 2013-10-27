<?php
/**
 *
 *
 */

namespace tests\Upvote\Application\Model;

use Upvote\Application\Model\UserModel;


class UserModelTest extends ModelTestCase {

	/**
	 * Model.
	 *
	 * @var UserModel
	 */
	protected $model;

	/**
	 * Creates database connection.
	 *
	 * @return void
	 */
	protected function setUp()
	{
		$this->modelClass = '\\Upvote\\Application\\Model\\UserModel';

		parent::setUp();
	}

	/**
	 * Test description.
	 *
	 * @return void
	 */
	public function testCreate()
	{
		$fields_hash = array(
			'username' => 'u',
			'email' => 'e',
			'password' => md5('up')
		);

		$this->db->shouldReceive('insert')->with($fields_hash, 'user')->andReturn('OK');

		$this->assertEquals('OK', $this->model->create('u', 'e', 'p'));
	}

	/**
	 * Test description.
	 *
	 * @return void
	 */
	public function testChangePassword()
	{
		$fields_hash = array(
			'password' => md5('unp'),
		);

		$this->db->shouldReceive('update')->with($fields_hash, 'user', 'username = ?', array('u'));

		$this->assertNull($this->model->changePassword('u', 'np'));
	}

	/**
	 * Test description.
	 *
	 * @param mixed   $user_info User info.
	 * @param boolean $found     User was found.
	 *
	 * @return void
	 * @dataProvider verifyCredentialsDataProvider
	 */
	public function testVerifyCredentials($user_info, $found)
	{
		$sql = 'SELECT *
				FROM user
				WHERE username = ? AND password = ?';

		$params = array(
			'u',
			md5('up'),
		);

		$this->db->shouldReceive('fetchRow')->with($sql, $params)->andReturn($user_info);

		$this->assertSame($found, $this->model->verifyCredentials('u', 'p'));
	}

	/**
	 * Data provider for "verifyCredentials" method testing.
	 *
	 * @return array
	 */
	public function verifyCredentialsDataProvider()
	{
		return array(
			array(array(), true),
			array(false, false),
		);
	}

	/**
	 * Test description.
	 *
	 * @return void
	 */
	public function testLookup()
	{
		$sql = 'SELECT *
				FROM user
				WHERE username = ?';

		$this->db->shouldReceive('fetchRow')->with($sql, array('u'))->andReturn('OK');

		$this->assertEquals('OK', $this->model->lookup('u'));
	}
}
