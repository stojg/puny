<?php

namespace stojg\puny\api;

/**
 * Facebook
 *
 */
class Facebook {

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
		$state = 'stojgovich';
		return sprintf('https://www.facebook.com/dialog/oauth?client_id=%u&redirect_uri=%s&state=%s&scope=user_photos,read_stream',
			$this->clientID,
			$callbackURL,
			$state
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

		$url = sprintf('https://graph.facebook.com/oauth/access_token?client_id=%u&redirect_uri=%s&client_secret=%s&code=%s',
			$this->clientID,
			$callbackURL,
			$this->clientSecret,
			$oauthCode
		);
		$response = $this->request($url, false);

		$params = null;
		parse_str($response, $params);

		$_SESSION['facebook_token'] = $params['access_token'];
		$userResponse = $this->request("https://graph.facebook.com/me?access_token=" . $params['access_token']);
		$_SESSION['facebook_user_id'] = $response['id'];
	}

	//me/albums

	/**
	 *
	 * @return string
	 */
	public function getRecentMedia() {
		return $this->fql("SELECT pid, src_big, src_big_height, src_big_width, caption, created FROM photo WHERE owner=me() ORDER BY created DESC LIMIT 30");
	}

	/**
	 *
	 * @return boolean | false
	 */
	protected function getAccessToken() {
		if(empty($_SESSION['facebook_token'])) {
			return false;
		}
		return $_SESSION['facebook_token'];
	}

	/**
	 *
	 * @return boolean | int
	 */
	protected function getUserID() {
		if(empty($_SESSION['facebook_user_id'])) {
			return false;
		}
		return $_SESSION['facebook_user_id'];
	}

	/**
	 *
	 * @param string $url
	 * @param array $postData
	 * @return array
	 * @throws \Exception
	 */
	protected function request($url, $json=true) {
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_TIMEOUT => 10,
		));
		if(false) {
			curl_setopt($ch, CURLOPT_POST, count($postData));
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
		}
		if(!$rawResult = curl_exec($ch)) {
			throw new \Exception(curl_error($ch));
		}

		$info = curl_getinfo($ch);
		curl_close($ch);
		
		if($info['http_code'] != 200) {
			$response = json_decode($rawResult, true);
			throw new \Exception('API call: '.$response['error']['type'].' - '.$response['error']['message']);
		}

		if(!$json) {
			return $rawResult;
		}

		return json_decode($rawResult, true);
	}

	/**
	 *
	 * @param string $query
	 * @return array
	 */
	protected function fql($query) {
		$params = array(
			'access_token' => $this->getAccessToken(),
			'q' => $query
		);
		return $this->request('https://graph.facebook.com/fql?'.http_build_query($params));
	}
}
