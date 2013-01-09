<?php

namespace stojg\puny;

/**
 * Puny
 *
 */
class Puny {

	/**
	 * Start a session with a specific timeout
	 *
	 * @param  int $seconds - the time out in seconds
	 * @return void
	 */
	public static function start_session($timeout = 1800) {
		session_cache_limiter(false);
		session_start();

		ini_set("session.gc_maxlifetime", $timeout);
		if(isset($_SESSION['lastSeen'])) {
			$heartbeatAgo = time() - $_SESSION['lastSeen'];
			$timeLeft = $timeout - $heartbeatAgo;
			if($timeLeft < 0) {
				$_SESSION = array();
			}
		}
		$_SESSION['lastSeen'] = time();
	}

	/**
	 * Get the protocol and host for the current site
	 *
	 * ex 'https://test.com/'
	 *
	 * @return string
	 */
	public static function protocol_and_host() {
		if(isset($_SERVER['HTTP_X_FORWARDED_PROTOCOL']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTOCOL']) == 'https') {
			return "https://" . $_SERVER['HTTP_HOST'];
		}
		if(isset($_SERVER['SSL']) || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')) {
			return "https://" . $_SERVER['HTTP_HOST'];
		}
		return "http://" . $_SERVER['HTTP_HOST'];
	}

}
