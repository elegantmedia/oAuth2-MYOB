<?php


namespace ElegantMedia\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Myob extends \League\OAuth2\Client\Provider\AbstractProvider
{

	/*
	|--------------------------------------------------------------------------
	| For more information about usage, check Myob Developer Docs
	|--------------------------------------------------------------------------
	|
	| @link https://developer.myob.com/api/accountright/api-overview/authentication/
	|
	*/

	/**
	 * @inheritDoc
	 */
	public function getBaseAuthorizationUrl()
	{
		return 'https://secure.myob.com/oauth2/account/authorize';
	}

	/**
	 * @inheritDoc
	 */
	public function getBaseAccessTokenUrl(array $params)
	{
		return 'https://secure.myob.com/oauth2/v1/authorize';
	}

	/**
	 * @inheritDoc
	 */
	public function getResourceOwnerDetailsUrl(AccessToken $token)
	{
		return 'https://secure.myob.com/oauth2/v1/Validate?scope=CompanyFile';
	}

	/**
	 * @inheritDoc
	 */
	protected function getDefaultScopes()
	{
		return [
			'CompanyFile la.global'
		];
	}

	/**
	 * @inheritDoc
	 */
	protected function checkResponse(ResponseInterface $response, $data)
	{
		// TODO: Implement checkResponse() method.
	}

	/**
	 * @inheritDoc
	 */
	protected function createResourceOwner(array $response, AccessToken $token): MyobUser
	{
		return new MyobUser($response);
	}

	/**
	 * Returns the authorization headers used by this provider.
	 *
	 * Typically this is "Bearer" or "MAC". For more information see:
	 * http://tools.ietf.org/html/rfc6749#section-7.1
	 *
	 * No default is provided, providers must overload this method to activate
	 * authorization headers.
	 *
	 * @param  mixed|null $token Either a string or an access token instance
	 * @return array
	 */
	protected function getAuthorizationHeaders($token = null)
	{
		/** @var AccessToken $token */
		return [
			'Authorization' => 'Bearer ' . $token->getToken(),
			'x-myobapi-key' => $this->clientId,
		];
	}
}
