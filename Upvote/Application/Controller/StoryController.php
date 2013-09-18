<?php

namespace Upvote\Application\Controller;


use Upvote\Application\Model\CommentModel;
use Upvote\Application\Model\StoryModel;
use Upvote\Library\Controller\Controller;
use Upvote\Library\View\View;

class StoryController extends Controller
{

	public function __construct($config)
	{
		parent::__construct($config);

		$this->model = new StoryModel($config);
		$this->authRequired['create'] = '/user/login';
	}

	public function index()
	{
		if ( !isset($_GET['id']) ) {
			header("Location: /");
			exit;
		}

		$story = $this->model->lookup($_GET['id']);

		if ( !$story ) {
			header("Location: /");
			exit;
		}

		$comment_model = new CommentModel($this->config);
		$comments = $comment_model->getStoryComments($story['id']);
		$comment_count = count($comments);

		$view = new View();

		$html = $view->parseTemplate('StoryHeading', array(
			'external_url' => $story['url'],
			'headline' => $story['headline'],
			'created_by' => $story['created_by'],
			'comment_count' => $comment_count,
			'created_on' => date('n/j/Y g:i a', strtotime($story['created_on'])),
		));

		if ( isset($_SESSION['AUTHENTICATED']) ) {
			$html .= $view->parseTemplate('AddCommentForm', array(
				'story_id' => $_GET['id'],
			));
		}

		foreach ( $comments as $comment ) {
			$html .= $view->parseTemplate('CommentElement', array(
				'created_by' => $comment['created_by'],
				'created_on' => date('n/j/Y g:i a', strtotime($comment['created_on'])),
				'comment_text' => $comment['comment'],
			));
		}

		return $view->setContent($html);
	}

	public function create()
	{
		$error = '';

		if ( isset($_POST['create']) ) {
			if ( !isset($_POST['headline']) || !isset($_POST['url']) ||
				!filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL)
			) {
				$error = 'You did not fill in all the fields or the URL did not validate.';
			}
			else {
				$story_id = $this->model->create($_POST['headline'], $_POST['url'], $_SESSION['username']);
				header("Location: /story/?id=$story_id");
				exit;
			}
		}

		$view = new View();

		$html = $view->parseTemplate('StoryCreateForm', array(
			'error' => $error,
		));

		return $view->setContent($html);
	}

}