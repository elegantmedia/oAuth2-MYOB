<?php

require_once(__DIR__.'/provider.php');

// These params should be stored locally and fetched
$token = '';
$refreshToken = '';
$expires = '1618993989';

$expiresAt = \DateTime::createFromFormat('U', $expires);

if ($expiresAt->getTimestamp() > time()) {
	echo "not expired \r\n";
} else {
	echo "expired \r\n";

	$accessToken = $provider->getAccessToken('refresh_token', [
		'refresh_token' => $refreshToken,
	]);

	// We have an access token, which we may use in authenticated
	// requests against the service provider's API.

	echo 'Access Token: ' . $accessToken->getToken() . "\r\n";
	echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "\r\n";
	echo 'Expires in: ' . $accessToken->getExpires() . "\r\n";
	echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "\r\n";

}

$user = $provider->getResourceOwner($accessToken);
echo 'User ID : ' . $user->getId() . "\r\n";
echo 'Username : ' . $user->getUsername() . "\r\n";
