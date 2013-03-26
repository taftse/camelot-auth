<?php namespace TwswebInt\CamelotAuth\AuthDrivers;

use TwswebInt\CamelotAuth\SessionDrivers\SessionDriverInterface;
use TwswebInt\CamelotAuth\CookieDrivers\CookieDriverInterface;
use TwswebInt\CamelotAuth\DatabaseDrivers\DatabaseDriverInterface;

class LocalAuthDriver extends AbstractAuthDriver{

	public function authenticate()
	{
		$oauthUser = $this->database->createModel('oauth2User');
		$oauthUser->find(1);
		var_dump($oauthUser->find(1));
	}


	public function register()
	{

	}
}