<?php

session_start();

require_once(__DIR__.'/provider.php');

// if you have a return URL from browser, you can use it for testing. Otherwise leave it empty.

$returnUrl = '';

if (!empty($returnUrl)) {
	$url = parse_url($returnUrl);
	parse_str($url['query'], $params);
} else {
	$params = [
		'code' => $_GET['code'] ?? null,
		'state' => $_GET['state'] ?? null,
	];

	// Important: On a browser, verify state to prevent CSRF
	if ($params['state'] !== $_SESSION['oauth2state']) {
		// invalid state, possible CSRF attack or delayed response
		unset($_SESSION['oauth2state']);
		exit('Invalid state. Try authorizing again.');
	}
}

if (empty($params['code'])) {
	exit('`code` is required.');
}

// valid state, so we try to get an access token
$accessToken = $provider->getAccessToken('authorization_code', [
	'code' => $params['code'],
]);

// We have an access token, which we may use in authenticated
// requests against the service provider's API.

// You'll have to store these for later use
echo 'Access Token: ' . $accessToken->getToken() . "\r\n\r\n";
echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "\r\n\r\n";
echo 'Expires in: ' . $accessToken->getExpires() . "\r\n\r\n";
echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "\r\n\r\n";

$user = $provider->getResourceOwner($accessToken);

// Get resource User
// https://apisupport.myob.com/hc/en-us/articles/360003860376-Validating-the-User
echo 'User ID : ' . $user->getId() . "\r\n";
echo 'Username : ' . $user->getUsername() . "\r\n";
