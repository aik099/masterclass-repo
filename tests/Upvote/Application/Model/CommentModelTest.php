<?php
/**
 *
 *
 */

namespace tests\Upvote\Application\Model;

use Upvote\Application\Model\CommentModel;


class CommentModelTest extends ModelTestCase {

	/**
	 * Model.
	 *
	 * @var CommentModel
	 */
	protected $model;

	/**
	 * Creates database connection.
	 *
	 * @return void
	 */
	protected function setUp()
	{
		$this->modelClass = '\\Upvote\\Application\\Model\\CommentModel';

		parent::setUp();
	}

	/**
	 * Test description.
	 *
	 * @return void
	 */
	public function testAddCommentToStory()
	{
		$fields_hash = array(
			'created_by' => 'u',
			'created_on' => date('Y-m-d H:i:s'),
			'story_id' => 's',
			'comment' => 'c',
		);

		$this->db->shouldReceive('insert')->with($fields_hash, 'comment')->andReturn('OK');

		$this->assertEquals('OK', $this->model->addCommentToStory('s', 'c', 'u'));
	}

	/**
	 * Test description.
	 *
	 * @return void
	 */
	public function testGetStoryComments()
	{
		$sql = 'SELECT *
				FROM comment
				WHERE story_id = ?';

		$this->db->shouldReceive('fetchAll')->with($sql, array('s'))->andReturn('OK');

		$this->assertEquals('OK', $this->model->getStoryComments('s'));
	}

	/**
	 * Test description.
	 *
	 * @param mixed   $query_result Query result.
	 * @param integer $expected     Expected comment count.
	 *
	 * @return void
	 * @dataProvider getStoryCommentCountDataProvider
	 */
	public function testGetStoryCommentCount($query_result, $expected)
	{
		$sql = 'SELECT COUNT(*) AS `count`
				FROM comment
				WHERE story_id = ?';

		$this->db->shouldReceive('fetchRow')->with($sql, array('s'))->andReturn($query_result);

		$this->assertEquals($expected, $this->model->getStoryCommentCount('s'));
	}

	/**
	 * Test data for getStoryCommentCount method testing.
	 *
	 * @return array
	 */
	public function getStoryCommentCountDataProvider()
	{
		return array(
			array(false, 0),
			array(array('count' => 5), 5),
		);
	}

}
