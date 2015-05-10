<?php namespace T4s\CamelotAuth\Config;

use Illuminate\Config\Repository;

class IlluminateConfig implements  ConfigInterface
{

    protected $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function load($fileName)
    {

    }

    public function get($key,$default = null)
    {
        return $this->config->get($key, $default);
    }

    public function set($key, $value)
    {
        return $this->config->set($key,$value);
    }

} 