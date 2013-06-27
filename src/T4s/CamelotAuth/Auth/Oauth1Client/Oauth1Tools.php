<?php namespace T4s\CamelotAuth\Auth\Oauth1Client;


class Oauth1Tools 

{
	public static function urlencode($value)
	{
		if(is_array($value))
		{
			return array_map(array('T4s\CamelotAuth\Auth\Oauth1Client\Oauth1Tools', 'urlencode'),$value);
		}
		return rawurlencode($value);
	}

	public static function urldecode($value)
	{
		if(is_array($value))
		{
			return array_map(array('T4s\CamelotAuth\Auth\Oauth1Client\Oauth1Tools', 'urldecode'),$value);
		}
		return rawurldecode($value);
	}

	public static function parseUrl($url)
	{
		if($query = parse_url($url,PHP_URL_QUERY))
		{
			list($url) = explode('?',$url,2);

			$params = Oauth1Tools::ParseParams($query);
		}
		else
		{
			$params = array();
		}

		return array($url,$params);
	}

	public static function ParseParams($params)
	{
		$params = explode('&', $params);

		$parsed = array();

		foreach ($params as $param)
		{
			// Split the parameter into name and value
			list($name, $value) = explode('=', $param, 2);

			// Decode the name and value
			$name  = Oauth1Tools::urldecode($name);
			$value = Oauth1Tools::urldecode($value);

			if (isset($parsed[$name]))
			{
				if ( ! is_array($parsed[$name]))
				{
					// Convert the parameter to an array
					$parsed[$name] = array($parsed[$name]);
				}

			// Add a new duplicate parameter
			$parsed[$name][] = $value;
			}
			else
			{
			// Add a new parameter
				$parsed[$name] = $value;
			}
		}

		return $parsed;
	}

	public static function normalizeParameters(array $parameters = null)
	{
		if(!$parameters)
		{
			return '';
		}

		$keys = Oauth1Tools::urlencode(array_keys($parameters));
		$values = Oauth1Tools::urlencode(array_values($parameters));

		$parameters = array_combine($keys, $values);

		uksort($parameters, 'strcmp');

		$query = array();

		foreach ($parameters as $key => $value)
		{
			if (is_array($value))
			{
				// OAuth Spec 9.1.1 (1)
				// "If two or more parameters share the same name, they are sorted by their value."
				$value = natsort($value);

				foreach ($value as $duplicate)
				{
					$query[] = $key.'='.$duplicate;
				}
			}
			else
			{
				$query[] = $key.'='.$value;
			}
		}

		return implode('&', $query);
	}
}