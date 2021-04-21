# Myob Provider for OAuth 2.0 Client

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)

This package allows you to use [Myob oAuth API](https://developer.myob.com/api/accountright/).

Before using it, you'll need an API key from [developer website](https://my.myob.com.au/).

Other reference links

| Website | URL |
|---|---|
| Developer Site | https://my.myob.com.au/ |
| API Reference | https://developer.myob.com/api/accountright/ |
| Postman Collection | https://accountrightapi.myob.cloud/?version=latest#intro |

## Install

Via Composer

``` bash
$ composer require elegantmedia/oauth2-myob
```

## Usage

### Authorization

The example below shows how to get an authorization URL from the Provider. For a complete example see [examples/auth.php](examples/auth.php).

``` php
require __DIR__ . '/vendor/autoload.php';

$provider = new \ElegantMedia\OAuth2\Client\Provider\Myob([
	'clientId' => 'your_client_id',
	'clientSecret' => 'your_secret',
	'redirectUri' => 'https://example.com/your-url',
]);

// get initial authorization URL
$authUrl = $provider->getAuthorizationUrl();

// save the state value in session to prevent CSRF attacks
$_SESSION['oauth2state'] = $provider->getState();

header('Location: ' . $authUrl);
exit;
```

### Get Token

The example below shows how to get an access token from the Provider. For a complete example see [examples/post.php](examples/post.php).

``` php
// valid state, so we try to get an access token
$accessToken = $provider->getAccessToken('authorization_code', [
	'code' => $params['code'],
]);

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
```

### Refresh Token

The example below shows how to get an a new token for an expired code. For a complete example see [examples/post.php](examples/refresh.php).

``` php
$refreshToken = 'old-token';
$expires = 'old-timestamp';

$expiresAt = \DateTime::createFromFormat('U', $expires);

if ($expiresAt->getTimestamp() > time()) {
	echo "Not expired \r\n";
} else {
	echo "Expired \r\n";

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
```

## Contributing

If you see any bugs, please send a pull-request.

## Credits

- [Elegant Media][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/elegantmedia/oauth2-myob.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/elegantmedia/oauth2-myob/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/elegantmedia/oauth2-myob.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/elegantmedia/oauth2-myob.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/elegantmedia/oauth2-myob.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/elegantmedia/oauth2-myob
[link-travis]: https://travis-ci.org/elegantmedia/oauth2-myob
[link-scrutinizer]: https://scrutinizer-ci.com/g/elegantmedia/oauth2-myob/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/elegantmedia/oauth2-myob
[link-downloads]: https://packagist.org/packages/elegantmedia/oauth2-myob
[link-author]: https://github.com/elegantmedia
[link-contributors]: ../../contributors
