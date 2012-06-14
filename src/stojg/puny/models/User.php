<?php

namespace stojg\puny\models;

/**
 *
 */
class User {

	/**
	 *
	 * @return string|boolean
	 */
	public function getUsername() {
		if(!isset($_SESSION['username'])) {
			return false;
		}
		return $_SESSION['username'];
	}

	/**
	 *
	 * @param string $name
	 * @return \stojg\puny\models\User
	 */
	public function setUsername($name) {
		$_SESSION['username'] = $name;
		return $this;
	}

	/**
	 *
	 * @return string|boolean
	 */
	public function getPassword() {
		if(!isset($_SESSION['password'])) {
			return false;
		}
		return $_SESSION['password'];
	}

	/**
	 *
	 * @param string $password
	 * @return \stojg\puny\models\User
	 */
	public function setPassword($password) {
		$_SESSION['password'] = $password;
		return $this;
	}

	/**
	 *
	 * @param Slim $app
	 * @return boolean
	 */
	public function login($app) {
		if(!$app->request()->isPost()) {
			return false;
		}

		$this->setUsername($app->request()->params('username'));
		$this->setPassword($app->request()->params('password'));

		return $this->valid();
	}

	/**
	 * Logout the user
	 * @return void
	 */
	public function logout() {
		session_destroy();
	}

	/**
	 * Does the actual check up the username and password is valid
	 *
	 * @return boolean
	 */
	public function valid() {
		if($this->getUsername() !== 'admin') {
			return false;
		}
		if($this->getPassword() !== 'password') {
			return false;
		}
		return true;
	}
}