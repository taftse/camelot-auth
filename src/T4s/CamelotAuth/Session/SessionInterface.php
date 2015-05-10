<?php namespace T4s\CamelotAuth\Session;


interface SessionInterface {

    public function getKey();

    public function put($value,$key= null);

    public function get($key= null,$default = null);

    public function forget($key= null);
} 