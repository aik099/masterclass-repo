<?php
/**
 *
 *
 */

namespace tests\Upvote\Application\Model;

use Upvote\Application\Model\StoryModel;


class StoryModelTest extends ModelTestCase {

	/**
	 * Model.
	 *
	 * @var StoryModel
	 */
	protected $model;

	/**
	 * Creates database connection.
	 *
	 * @return void
	 */
	protected function setUp()
	{
		$this->modelClass = '\\Upvote\\Application\\Model\\StoryModel';

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
			'headline' => 'h',
			'url' => 'u',
			'created_by' => 'un',
			'created_on' => date('Y-m-d H:i:s'),
		);

		$this->db->shouldReceive('insert')->with($fields_hash, 'story')->andReturn('OK');

		$this->assertEquals('OK', $this->model->create('h', 'u', 'un'));
	}

	/**
	 * Test description.
	 *
	 * @return void
	 */
	public function testLookup()
	{
		$sql = 'SELECT *
				FROM story
				WHERE id = ?';

		$this->db->shouldReceive('fetchRow')->with($sql, array('x'))->andReturn('OK');

		$this->assertEquals('OK', $this->model->lookup('x'));
	}

	/**
	 * Test description.
	 *
	 * @return void
	 */
	public function testGetAllStories()
	{
		$sql = 'SELECT *
				FROM story
				ORDER BY created_on DESC';

		$this->db->shouldReceive('fetchAll')->with($sql)->andReturn('OK');

		$this->assertEquals('OK', $this->model->getAllStories());
	}

}
