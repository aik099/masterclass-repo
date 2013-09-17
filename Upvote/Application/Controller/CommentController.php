<?php

namespace Upvote\Application\Controller;


use Upvote\Application\Model\CommentModel;
use Upvote\Library\Controller\Controller;

class CommentController extends Controller
{

	public function __construct($config)
	{
		parent::__construct($config);

		$this->model = new CommentModel($config);
		$this->authRequired['create'] = '/';
	}

	public function create()
	{
		$this->model->addCommentToStory($_POST['story_id'], $_POST['comment'], $_SESSION['username']);

		header("Location: /story/?id=" . $_POST['story_id']);
	}

}