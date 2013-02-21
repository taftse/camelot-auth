<?php namespace TwswebInt\CamelotAuth\AuthDrivers;

use Config;
use Input;
use Validator;
use Request;
use TwswebInt\CamelotAuth\UserInterface as UserInterface;

class Oauth2CamelotDriver extends CamelotDriver
{

	public function authenticate()
	{
		echo 'oauth2';
	}
}