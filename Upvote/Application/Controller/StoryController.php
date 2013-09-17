<?php

namespace Upvote\Application\Controller;


use Upvote\Application\Model\CommentModel;
use Upvote\Application\Model\StoryModel;
use Upvote\Library\Controller\Controller;

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

		$content = '
            <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
            <span class="details">' . $story['created_by'] . ' | ' . $comment_count . ' Comments |
            ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
        ';

		if ( isset($_SESSION['AUTHENTICATED']) ) {
			$content .= '
            <form method="post" action="/comment/create">
            <input type="hidden" name="story_id" value="' . $_GET['id'] . '" />
            <textarea cols="60" rows="6" name="comment"></textarea><br />
            <input type="submit" name="submit" value="Submit Comment" />
            </form>
            ';
		}

		foreach ( $comments as $comment ) {
			$content .= '
                <div class="comment"><span class="comment_details">' . $comment['created_by'] . ' | ' .
				date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                ' . $comment['comment'] . '</div>
            ';
		}

		require FULL_PATH . '/Upvote/Application/View/layout.phtml';

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

		$content = '
            <form method="post">
                ' . $error . '<br />

                <label>Headline:</label> <input type="text" name="headline" value="" /> <br />
                <label>URL:</label> <input type="text" name="url" value="" /><br />
                <input type="submit" name="create" value="Create" />
            </form>
        ';

		require FULL_PATH . '/Upvote/Application/View/layout.phtml';
	}

}