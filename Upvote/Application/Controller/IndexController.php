<?php

namespace Upvote\Application\Controller;


use Upvote\Application\Model\CommentModel;
use Upvote\Application\Model\StoryModel;
use Upvote\Library\Controller\Controller;
use Upvote\Library\Database\DatabaseFactory;
use Upvote\Library\View\View;

class IndexController extends Controller
{

	protected $db;

	public function __construct($config)
	{
		parent::__construct($config);

		$this->model = new StoryModel(new DatabaseFactory(), $config);
	}

	public function index()
	{
		$stories = $this->model->getAllStories();
		$comment_model = new CommentModel(new DatabaseFactory(), $this->config);

		$items = '';
		$view = new View();

		foreach ( $stories as $story ) {
			$count = $comment_model->getStoryCommentCount($story['id']);

			$items .= $view->parseTemplate('StoryElement', array(
				'external_url' => $story['url'],
				'headline' => $story['headline'],
				'created_by' => $story['created_by'],
				'created_on' => $this->formatDate($story['created_on']),
				'story_url' => '/story/?id=' . $story['id'],
				'comment_count' => $count,
			));
		}

		$html = $view->parseTemplate('List', array(
			'items' => $items,
		));

		return $view->setContent($html);
	}
}