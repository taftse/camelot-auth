<?php namespace T4s\CamelotAuth\Auth\Oauth1Client\Requests;

use T4s\CamelotAuth\Auth\Oauth1Client\Oauth1Tools;
use T4s\CamelotAuth\Auth\Oauth1Client\Signatures\AbstractSignature;

class AbstractRequest
{

	/**
	 * the request request method used eg. GET, POST, etc
	 *
	 * @var string 
	 */
	protected $methoud = 'GET';

	/**
	 * The request url
	 *
	 * @var string
	 */
	protected $url;

	protected $required = array();

	/**
	 * an array of additional request parameters
	 *
	 * @var array
	 */
	protected $params = array();

	
	public function __constructor($method,$url)
	{
		$this->method = strtoupper($method);

		list($this->url,$defaultParams) = Oauth1Tools::parseUrl($url);

		if($this->required('oauth_version') AND !isset($this->params['oauth_version']))
		{
			$this->params['oauth_version'] = Oauth1Client::$version;
		}

		if($this->required('oauth_timestamp') AND !isset($this->params['oauth_timestamp']))
		{
			$this->params['oauth_timestamp'] = time();
		}

		if($this->required('oauth_nonce') AND !isset($this->params['oauth_nonce']))
		{
			$this->params['oauth_nonce'] = $this->getNonce();
		}
	}


	public function required($key,$value = null)
	{
		if($value === null)
		{
			return ! empty($this->required[$param]);
		}

	}

	public function getNonce()
	{
		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr(str_shuffle(str_repeat($pool, ceil(40 / strlen($pool)))), 0, 40);
	}

	public function sign(AbstractSignature $signature,$token = null)
	{
		$this->params['oauth_signature_method']= $signature->name;

		$this->params['oauth_signature'] = $signature->sign($token);
	}


	/*public function __constructor($method,$url,array $requiredParams= null,array $params = null)
	{
		$this->method = strtoupper($method);

		list($this->url,$defaultParams) = Oauth1Tools::parseUrl($url);

		if($defaultParams)
		{
			$this->params($defaultParams);
		}

		if($params)
		{
			$this->params($params);
		}

		if(array_key_exists('version', $requiredParams) AND !isset($this->params['oauth_version']))
		{
			$this->params['oauth_version'] = Oauth1Client::$version;
		}

		if(array_key_exists('timestamp', $requiredParams) AND !isset($this->params['oauth_timestamp']))
		{
			$this->params['oauth_timestamp'] = time();
		}

		if(array_key_exists('nonce', $requiredParams) AND !isset($this->params['oauth_nonce']))
		{
			$this->params['oauth_nonce'] = $this->getNonce();
		}
	}


	

	public function sign(AbstractSignature $signer)
	{
		$this->params['oauth_signature_method'] = $signer->name;

		$this->params['oauth_signature'] = $signer->sign($this);

	}
*/

}