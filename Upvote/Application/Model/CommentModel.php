<?php

namespace Upvote\Application\Model;


use Upvote\Library\Model\Model;

class CommentModel extends Model
{

	/**
	 * Adds new comment to a story.
	 *
	 * @param integer $story_id     Story ID.
	 * @param string  $comment_text Comment text.
	 * @param string  $username     Username.
	 *
	 * @return integer
	 */
	public function addCommentToStory($story_id, $comment_text, $username)
	{
		$fields_hash = array(
			'created_by' => $username,
			'created_on' => date('Y-m-d H:i:s'),
			'story_id' => $story_id,
			'comment' => filter_var($comment_text, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
		);

		return $this->db->insert($fields_hash, 'comment');
	}

	/**
	 * Returns comments of given story.
	 *
	 * @param integer $story_id Story ID.
	 *
	 * @return array
	 */
	public function getStoryComments($story_id)
	{
		$sql = 'SELECT *
				FROM comment
				WHERE story_id = ?';

		return $this->db->fetchAll($sql, array($story_id));
	}

	/**
	 * Returns comments count of given story.
	 *
	 * @param integer $story_id Story ID.
	 *
	 * @return array
	 */
	public function getStoryCommentCount($story_id)
	{
		$sql = 'SELECT COUNT(*) AS `count`
				FROM comment
				WHERE story_id = ?';

		$data = $this->db->fetchRow($sql, array($story_id));

		return $data ? $data['count'] : 0;
	}

}
