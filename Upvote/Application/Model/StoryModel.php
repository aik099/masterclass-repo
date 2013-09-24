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
		$fields_hash = array(
			'headline' => $headline,
			'url' => $url,
			'created_by' => $username,
			'created_on' => date('Y-m-d H:i:s'),
		);

		return $this->db->insert($fields_hash, 'story');
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

		return $this->db->fetchRow($sql, array($story_id));
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

		return $this->db->fetchAll($sql);
	}

}
