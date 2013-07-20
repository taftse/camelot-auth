<?php namespace T4s\CamelotAuth\Auth\Oauth1Client\Signatures;

use T4s\CamelotAuth\Auth\Oauth1Client\Requests\AbstractRequest;
use T4s\CamelotAuth\Auth\Oauth1Client\Oauth1Tools;
abstract class AbstractSignature
{

	protected $clientSecret;

	protected $name;

	protected $request;

	public function __construct(AbstractRequest $request,$clientSecret)
	{
		$this->request = $request;
		$this->clientSecret = $clientSecret;
	}


	/**
	* Return the value of any protected class variables.
	*
	* $name = $signature->name;
	*
	* @param string variable name
	* @return mixed
	*/
	public function __get($key)
	{
		return $this->$key;
	}

	public function key($token = null)
	{
		$key = Oauth1Tools::urlencode($this->clientSecret).'&';

		if($token)
		{
			$key .=Oauth1Tools::urlencode($token['oauth_token_secret']);
		}

		return $key;
	}

	abstract public function sign($token = null);

	abstract public function verify($signature,$token = null);
}

