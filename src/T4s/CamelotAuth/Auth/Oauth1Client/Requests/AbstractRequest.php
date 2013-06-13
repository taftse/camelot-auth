<?php namespace T4s\CamelotAuth\Auth\Oauth1Client\Requests;

use T4s\CamelotAuth\Auth\Oauth1ClientAuth;
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

	protected $sendHeader = TRUE;

	/**
	 * the request timeout
	 *
	 *@var integer
	 */
	protected $timeout = 10;

	protected $required = array();

	/**
	 * an array of additional request parameters
	 *
	 * @var array
	 */
	protected $params = array();

	
	public function __construct($method,$url,$params)
	{
		$this->method = strtoupper($method);


		list($this->url,$defaultParams) = Oauth1Tools::parseUrl($url);

		if($defaultParams)
		{
			$this->params($default);
		}

		if($params)
		{
			$this->params($params);
		}

		if($this->required('oauth_version') AND !isset($this->params['oauth_version']))
		{
			$this->params['oauth_version'] = Oauth1ClientAuth::$version;
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

	public function param($name, $value = NULL, $duplicate = FALSE)
	{
		if ($value === NULL)
		{
			// Get the parameter
			return isset($this->params[$name]) ? $this->params[$name] : null;
		}

		if (isset($this->params[$name]) AND $duplicate)
		{
			if ( ! is_array($this->params[$name]))
			{
				// Convert the parameter into an array
				$this->params[$name] = array($this->params[$name]);
			}

			// Add the duplicate value
			$this->params[$name][] = $value;
		}
		else
		{
			// Set the parameter value
			$this->params[$name] = $value;
		}

		return $this;
	}

	public function params(array $params, $duplicate = FALSE)
	{
		foreach ($params as $name => $value)
		{
			$this->param($name, $value, $duplicate);
		}

		return $this;
	}

	public function required($key,$value = null)
	{
		if($value === null)
		{
			return ! empty($this->required[$key]);
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


	public function getBaseString()
	{
		$params = $this->params;

		unset($params['oauth_signature']);
		
		return implode('&', array(
								$this->method,
								Oauth1Tools::urlencode($this->url),
								Oauth1Tools::urlencode(
										Oauth1Tools::normalizeParameters($params)),
								)
						);
	}
	
	public function getHeader()
	{
			$header = array();

			foreach ($this->params as $key => $value) 
			{
				if(strpos($key,'oauth_')===0)
				{
					$header[] = Oauth1Tools::urlencode($key).'="'.Oauth1Tools::urlencode($value).'"';
				}
			}
			return 'OAuth '.implode(',',$header);
	}

	public function getQuery($includeOAuth = null,$asString = true)
	{
		if($includeOAuth ===null)
		{

			$includeOAuth = ! $this->sendHeader;
		}
		if($includeOAuth)
		{

				$params = $this->params;
		}
		else
		{
				$params = array();
				foreach ($this->params as $name => $value)
				{
					if (strpos($name, 'oauth_') !== 0)
					{
						// This is not an OAuth parameter
						$params[$name] = $value;
					}
				}
		}

		if($asString)
		{
			return Oauth1Tools::normalizeParameters($params);
		}
		return $params;
	}

	public function check()
	{

	}

	public function execute(array $options = array())
	{
		$this->check();

		$url = $this->url;

			if (ENVIRONMENT === 'development')
			{
				$options[CURLOPT_SSL_VERIFYPEER] = false;
			}

		if ( ! isset($options[CURLOPT_CONNECTTIMEOUT]))
		{
			// Use the request default timeout
			$options[CURLOPT_CONNECTTIMEOUT] = $this->timeout;
		}

		if($this->sendHeader)
		{
			$headers = array();
			if(isset($options[CURLOPT_HTTPHEADER]))
			{
				$headers = $options[CURLOPT_HTTPHEADER];
			}
			$headers[] = 'Authorization: '.$this->getHeader();
			$options[CURLOPT_HTTPHEADER] = $headers;
			var_dump($headers);
		}
		

		if($this->method === "POST")
		{
			$options[CURLOPT_POST] = true;

			if($post = $this->getQuery())
			{
				$options[CURLOPT_POSTFIELDS] = $post;
			}
		}
		else if($query = $this->getQuery())
		{
			$url = ''.$url.'?'.$query.'';
		}

		$options[CURLOPT_RETURNTRANSFER] = TRUE;

		$remote = curl_init($url);

		if(!curl_setopt_array($remote, $options))
		{
			throw new \Exception('Failed to set CURL options, check CURL documentation: http://php.net/curl_setopt_array');
		}

	
		// Get the response
		$response = curl_exec($remote);

		$responseCode = curl_getinfo($remote, CURLINFO_HTTP_CODE);

		if ($responseCode AND ($responseCode < 200 OR $responseCode > 299))
		{
			$error = $response;
		}
		elseif ($response === FALSE)
		{
			$error = curl_error($remote);
		}

		// Close the connection
		curl_close($remote);

		if (isset($error))
		{
			throw new \Exception(sprintf('Error fetching remote %s [ status %s ] %s', $url, $responseCode, $error));
		}

		return $response;
	}

}