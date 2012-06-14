<?php

namespace stojg\puny\helpers;

class ViewHelper extends \Slim_Middleware {

	public function call() {
		$this->app->view()->appendData(array(
			'user' => new \stojg\puny\models\User(),
			'app' => $this->app
		));

		$this->next->call();
	}
}