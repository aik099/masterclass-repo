<?php

namespace Upvote\Application\Controller;


use Upvote\Application\Model\CommentModel;
use Upvote\Application\Model\StoryModel;
use Upvote\Library\Controller\Controller;

class IndexController extends Controller
{

	protected $db;

	public function __construct($config)
	{
		parent::__construct($config);

		$this->model = new StoryModel($config);
	}

	public function index()
	{
		$stories = $this->model->getAllStories();
		$comment_model = new CommentModel($this->config);

		$content = '<ol>';

		foreach ( $stories as $story ) {
			$count = $comment_model->getStoryCommentCount($story['id']);

			$content .= '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story/?id=' . $story['id'] . '">' . $count . ' Comments</a> |
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
		}

		$content .= '</ol>';

		require FULL_PATH . '/Upvote/Application/View/layout.phtml';
	}
}