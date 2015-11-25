<?php namespace T4S\CamelotAuth\Config;


interface ConfigInterface {


    public function load($fileName);

    public function get($key,$default = null);

    public function set($key, $value);

} 