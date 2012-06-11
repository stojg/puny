<?php

/**
 * Define system paths
 */
if(!defined('BASE_PATH')) {
	// Assuming that this file is framework/core/Core.php we can then determine the base path
	$candidateBasePath = rtrim(dirname(dirname(dirname(__FILE__))), DIRECTORY_SEPARATOR);
	// We can't have an empty BASE_PATH.  Making it / means that double-slashes occur in places but that's benign.
	// This likely only happens on chrooted environemnts
	if($candidateBasePath == '') $candidateBasePath = DIRECTORY_SEPARATOR;
	define('BASE_PATH', $candidateBasePath);
}

if(!defined('BASE_URL')) {
	// Determine the base URL by comparing SCRIPT_NAME to SCRIPT_FILENAME and getting common elements
	$path = realpath($_SERVER['SCRIPT_FILENAME']);
	if(substr($path, 0, strlen(BASE_PATH)) == BASE_PATH) {
		$urlSegmentToRemove = substr($path, strlen(BASE_PATH));
		if(substr($_SERVER['SCRIPT_NAME'], -strlen($urlSegmentToRemove)) == $urlSegmentToRemove) {
			$baseURL = substr($_SERVER['SCRIPT_NAME'], 0, -strlen($urlSegmentToRemove));
			define('BASE_URL', rtrim($baseURL).DIRECTORY_SEPARATOR);
		}
	}
	// If that didn't work, failover to the old syntax.  Hopefully this isn't necessary, and maybe
	// if can be phased out?
	if(!defined('BASE_URL')) {
		$dir = (strpos($_SERVER['SCRIPT_NAME'], 'index.php') !== false)
			? dirname($_SERVER['SCRIPT_NAME'])
			: dirname(dirname($_SERVER['SCRIPT_NAME']));
		define('BASE_URL', rtrim($dir).DIRECTORY_SEPARATOR);
	}
}

if(!defined('THEME_URL')) {
	define('THEME_URL', BASE_URL.'themes'.DIRECTORY_SEPARATOR.THEME_NAME.DIRECTORY_SEPARATOR);
}