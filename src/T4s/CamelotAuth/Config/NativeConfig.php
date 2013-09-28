<?php namespace T4s\CamelotAuth\Config;



class NativeConfig implements ConfigInterface
{

	protected $configDir;

	protected $configs = array();

	protected $parsed = array();

	public function __construct($configDir = '')
	{
		$this->configDir = $configDir;
	}

	

	public function get($key,$default = null)
	{
		return $this->config->get('camelot-auth::'.$key, $default);
	}

	public function set($key, $value)
	{
		return $this->config->set('camelot-auth::'.$key,$value);
	}






	protected function parseKey($key)
	{
		//if we have already parsed the key then just return the result
		if(isset($this->parsed[$key]))
		{
			return $this->parsed[$key];
		}

		// if the key does not contain a double colon then its not namespaced 
		// and is a regular configuration item 
		if(strrpos($key, '::') ===false)
		{
			$parsed = $this->parseBasicSegments(explode('.', $key));
		}
		else
		{
			$parsed = $this->parseNamespacedSegments();
		}

		// we now we have parsed the array of keys so lets add them to the parsed 
		// array and return the results 

		return $this->parsed[$key] = $parsed;
	}

	protected function parseBasicSegments(array $segments)
	{
		// the first parameter will always be a group of config settings
		$group = $segments[0];

		// if there is only 1 segment then we want the whole group and not a single item
		if(count($segments) == 1)
		{
			return array(null,$group,null);
		}
		// if we have more than one segment then we want a single config item 
		// so we need to return the group and the items name 
		else
		{
			$item = implode('.', array_slice($segments, 1));

			return array(null,$group,$item);
		}
	}

	protected function parseNamespacedSegments($key)
	{
		list($namespace, $item) = explode('::',$key);

		$groupWithItems = array_slice($this->parseBasicSegments(explode('.',$item)),1);

		return array_merge(array($namespace),$groupWithItems);
	}
}