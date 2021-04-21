<?php

session_start();

require_once(__DIR__.'/provider.php');

// If we don't have an authorization code then get one
$authUrl = $provider->getAuthorizationUrl();
$_SESSION['oauth2state'] = $provider->getState();

var_dump($_SESSION['oauth2state']);

echo "Visit this URL in your browser to authenticate... \r\n";
echo $authUrl;
echo "\r\n";
