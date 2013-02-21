<?php namespace TwswebInt\CamelotAuth\SessionDrivers;


interface SessionDriverInterface{

	public function getKey();

	public function put($value);

	public function get();

	public function forget();
}