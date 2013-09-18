<?php
/**
 *
 *
 */

namespace Upvote\Library\View;

class View
{
	protected $content = '';

	protected $layoutFile = '';

	/**
	 * Creates view.
	 *
	 * @param string|null $layout_file Layout filename.
	 */
	public function __construct($layout_file = null)
	{
		$this->layoutFile = FULL_PATH . (isset($layout_file) ? $layout_file : '/Upvote/Application/View/layout.phtml');
	}

	/**
	 * Sets content.
	 *
	 * @param string $content Content.
	 *
	 * @return self
	 */
	public function setContent($content)
	{
		$this->content = $content;

		return $this;
	}

	/**
	 * Renders given parameters in given view.
	 *
	 * @param string $view_name View name.
	 * @param array  $params    View parameters.
	 *
	 * @return string
	 */
	public function parseTemplate($view_name, array $params = array())
	{
		ob_start();
		require FULL_PATH . '/Upvote/Application/View/' . $view_name . '.phtml';
		$template = ob_get_clean();

		foreach ( $params as $param_name => $param_value ) {
			$template = str_replace('{' . $param_name . '}', $param_value, $template);
		}

		return $template;
	}

	/**
	 * Renders view.
	 *
	 * @return string
	 */
	public function render()
	{
		$content = $this->content;

		ob_start();
		require $this->layoutFile;

		return ob_get_clean();
	}

	/**
	 * Renders a view in case if somebody tries to output it.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->render();
	}

}
