<?php

namespace Upvote\Application\Controller;


use Upvote\Application\Model\CommentModel;
use Upvote\Library\Controller\Controller;

class CommentController extends Controller
{

	/**
	 * Sets up the controller internals.
	 *
	 * @return void
	 */
	protected function setup()
	{
		parent::setup();

		$this->model = new CommentModel($this->db);
		$this->authRequired['create'] = '/';
	}

	public function create()
	{
		$this->model->addCommentToStory($_POST['story_id'], $_POST['comment'], $_SESSION['username']);

		header("Location: /story/?id=" . $_POST['story_id']);
	}

}