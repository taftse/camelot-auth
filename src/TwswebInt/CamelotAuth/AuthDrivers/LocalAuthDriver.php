<?php namespace TwswebInt\CamelotAuth\AuthDrivers;

use TwswebInt\CamelotAuth\Session\SessionInterface;
use TwswebInt\CamelotAuth\CookieDrivers\CookieDriverInterface;
use TwswebInt\ICamelotAuth\Database\DatabaseInterface;

class LocalAuthDriver extends AbstractAuthDriver{

	public function authenticate()
	{
		$oauthUser = $this->database->createModel('oauth2User');
		$oauthUser->find(1);

		
		var_dump();
	}


	public function register()
	{

	}
}