<?php


namespace ElegantMedia\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class MyobUser implements ResourceOwnerInterface
{

	protected $response;


	/**
	 * @param array $response
	 */
	public function __construct(array $response)
	{
		$this->response = $response;
	}

	public function getId()
	{
		return $this->response['Uid'];
	}

	public function getUsername()
	{
		return $this->response['username'] ?? null;
	}

	public function getTokenExpiry()
	{
		return $this->response['utc_token_expiry'] ?? null;
	}

	public function toArray()
	{
		return $this->response;
	}
}
