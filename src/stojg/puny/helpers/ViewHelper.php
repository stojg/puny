<?php

namespace stojg\puny\helpers;

/**
 * This class is added to Slim as a middleware and will expose some variables
 * to the view.
 */
class ViewHelper extends \Slim_Middleware {

	/**
	 * Adds a couple of variables to the view
	 */
	public function call() {
		$this->app->view()->appendData(array(
			'user' => new \stojg\puny\models\User(),
			'app' => $this->app
		));

		$this->next->call();
	}
}