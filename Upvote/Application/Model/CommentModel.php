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
	 * @return void
	 */
	public function addCommentToStory($story_id, $comment_text, $username)
	{
		$sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
		$stmt = $this->db->prepare($sql);

		$stmt->execute(array(
			$username,
			$story_id,
			filter_var($comment_text, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
		));
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
		$stmt = $this->db->prepare($sql);

		$stmt->execute(array($story_id));

		return $stmt->rowCount() ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : array();
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
		$stmt = $this->db->prepare($sql);

		$stmt->execute(array($story_id));

		if ( $stmt->rowCount() > 0 ) {
			$data = $stmt->fetch(\PDO::FETCH_ASSOC);

			return $data['count'];
		}

		return 0;
	}

}
