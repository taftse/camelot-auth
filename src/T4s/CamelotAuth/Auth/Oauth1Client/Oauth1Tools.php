<?php namespace T4s\CamelotAuth\Auth\Oauth1Client;


class Oauth1Tools 

{
	public static function urldecode($value)
	{
		if(is_array($value))
		{
			return array_map(array('Oauth1Tools', 'urldecode'),$value);
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
}