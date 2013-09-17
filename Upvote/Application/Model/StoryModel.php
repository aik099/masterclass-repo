<?php

namespace Upvote\Application\Model;


use Upvote\Library\Model\Model;

class StoryModel extends Model
{

	/**
	 * Creates story.
	 *
	 * @param string $headline Story headline.
	 * @param string $url      Story external url.
	 * @param string $username Username.
	 *
	 * @return integer
	 */
	public function create($headline, $url, $username)
	{
		$sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
		$stmt = $this->db->prepare($sql);

		$params = array(
			$headline,
			$url,
			$username,
		);

		$stmt->execute($params);

		return $this->db->lastInsertId();
	}

	/**
	 * Searches for story in database.
	 *
	 * @param integer $story_id Story ID.
	 *
	 * @return array
	 */
	public function lookup($story_id)
	{
		$sql = 'SELECT *
				FROM story
				WHERE id = ?';
		$stmt = $this->db->prepare($sql);

		$stmt->execute(array($story_id));

		return $stmt->rowCount() ? $stmt->fetch(\PDO::FETCH_ASSOC) : array();
	}

	/**
	 * Returns all stories.
	 *
	 * @return array
	 */
	public function getAllStories()
	{
		$sql = 'SELECT *
				FROM story
				ORDER BY created_on DESC';
		$stmt = $this->db->prepare($sql);

		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

}
