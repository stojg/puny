<?php

/**
 * BASE_PATH represents the path on disk to this application
 */
if(!defined('BASE_PATH')) {
	$candidateBasePath = __DIR__;
	// This likely only happens on chrooted environemnts
	if($candidateBasePath == '') $candidateBasePath = DIRECTORY_SEPARATOR;
	define('BASE_PATH', $candidateBasePath);
}

// BASE_URL represent the full URL path from the web root to this application
if(!defined('BASE_URL')) {
	$path = realpath($_SERVER['SCRIPT_FILENAME']);
	if(substr($path, 0, strlen(BASE_PATH)) == BASE_PATH) {
		$urlSegmentToRemove = substr($path, strlen(BASE_PATH));
		if(substr($_SERVER['SCRIPT_NAME'], -strlen($urlSegmentToRemove)) == $urlSegmentToRemove) {
			$baseURL = substr($_SERVER['SCRIPT_NAME'], 0, -strlen($urlSegmentToRemove));
			define('BASE_URL', trim($baseURL).DIRECTORY_SEPARATOR);
		}
	}
	// If that didn't work, try using the dirname of the called script index.php
	if(!defined('BASE_URL')) {
		define('BASE_URL', dirname($_SERVER['SCRIPT_NAME']).DIRECTORY_SEPARATOR);
	}
}

// Set the theme url, used in templates as
//		{{ constant('THEME_URL') }}
if(!defined('THEME_URL')) {
	define('THEME_URL', BASE_URL.'themes'.DIRECTORY_SEPARATOR.THEME_NAME.DIRECTORY_SEPARATOR);
}

if(!defined('USERNAME')) {
	define('USERNAME', 'admin');
}

if(!defined('PASSWORD')) {
	define('PASSWORD', 'password');
}