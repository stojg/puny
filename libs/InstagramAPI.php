<?php

/**
 * Simple oauth login to Instagram's API
 */
class InstagramAPI {

	/**
	 *
	 * @var string
	 */
	protected $clientID = '';

	/**
	 *
	 * @var string
	 */
	protected $clientSecret = '';

	/**
	 *
	 * @param string $clientID
	 * @param string $clientSecret
	 */
	public function __construct($clientID, $clientSecret) {
		$this->clientID = $clientID;
		$this->clientSecret = $clientSecret;
	}

	/**
	 * Get the URL to use for requesting user permissions
	 *
	 * @param string $callbackURL
	 * @return string
	 */
	public function getAuthURL($callbackURL) {
		return sprintf(
			'https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&response_type=code',
			$this->clientID,
			$callbackURL
		);
	}

	/**
	 * Check if user is logged in and authorised with instagram
	 *
	 * @return boolean
	 */
	public function isLoggedIn() {
		if(!$this->getAccessToken()) {
			return false;
		}
		if(!$this->getUserID()) {
			return false;
		}
		return true;
	}

	/**
	 *
	 * @param string $oauthCode
	 * @param string $callbackURL
	 */
	public function login($oauthCode, $callbackURL) {
		$postData = array(
			'client_id' => INSTAGRAM_CLIENT_ID,
			'client_secret' => INSTAGRAM_CLIENT_SECRET,
			'grant_type' => 'authorization_code',
			'redirect_uri' => $callbackURL,
			'code' => $oauthCode,
		);
		$response = $this->request('https://api.instagram.com/oauth/access_token', $postData);
		$_SESSION['instagram_token'] = $response['access_token'];
		$_SESSION['instagram_user_id'] = $response['user']['id'];
	}

	/**
	 *
	 * @return string
	 */
	public function getRecentMedia() {
		$apiURL = sprintf('https://api.instagram.com/v1/users/%d/media/recent/?access_token=%s',
			$this->getUserID(), $this->getAccessToken()
		);
		return $this->request($apiURL);
	}

	/**
	 *
	 * @param string $url
	 * @param array $postData
	 * @return array
	 * @throws Exception
	 */
	protected function request($url, $postData = array()) {
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_TIMEOUT => 10,
		));
		if($postData) {
			curl_setopt($ch, CURLOPT_POST, count($postData));
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
		}
		if(!$rawResult = curl_exec($ch)) {
			throw new Exception(curl_error($ch));
		}
		curl_close($ch);
		$response = json_decode($rawResult, true);

		if(isset($response['error_type'])) {
			throw new Exception('API call: '.$response['error_type'].' - '.$response['error_message']);
		}

		if(isset($response['meta']['error_type'])) {
			throw new Exception('API call: '.$response['meta']['error_type'].' - '.$response['meta']['error_message']);
		}
		return $response;
	}

	/**
	 *
	 * @return boolean | false
	 */
	protected function getAccessToken() {
		if(empty($_SESSION['instagram_token'])) {
			return false;
		}
		return $_SESSION['instagram_token'];
	}

	/**
	 *
	 * @return boolean | int
	 */
	protected function getUserID() {
		if(empty($_SESSION['instagram_user_id'])) {
			return false;
		}
		return $_SESSION['instagram_user_id'];
	}
}