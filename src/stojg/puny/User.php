<?php

namespace stojg\puny;

/**
 * Represents a user of the site, logged in or not doesn't matter.
 *
 */
class User {

	/**
	 * Checks if the current user is an admin
	 *
	 * @return boolean
	 */
	public static function is_logged_in() {
		static $user = null;
		if($user === null) {
			$user = new User();
		}
		return $user->valid();
	}

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
	 * Get the password the users password
	 *
	 * @return string|boolean - returns false if no password has been entered
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
		if($this->getUsername() !== USERNAME) {
			return false;
		}
		if($this->getPassword() !== PASSWORD) {
			return false;
		}
		return true;
	}

}