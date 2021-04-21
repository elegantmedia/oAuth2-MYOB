<?php

require_once(__DIR__.'/../vendor/autoload.php');

$provider = new \ElegantMedia\OAuth2\Client\Provider\Myob([
	'clientId' => 'your-client-id',
	'clientSecret' => 'your-secrect',
	'redirectUri' => 'https://example.com/your-redirect-uri',
]);
