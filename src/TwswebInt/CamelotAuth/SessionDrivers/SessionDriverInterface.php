<?php namespace TwswebInt\CamelotAuth\SessionDrivers;


interface SessionDriverInterface{

	public function getKey();

	public function put($value,$key= null);

	public function get($key= null);

	public function forget($key= null);
}