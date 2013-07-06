<?php namespace T4s\CamelotAuth\Config;

class IlluminateConfig implements ConfigInterface
{
	public function load($fileName)
	{

	}

	public function get($key,$default)
	{
		return Config::get($key, $default);
	}

	public function set($key, $value)
	{
		return Config::set($key,$value);
	}
}