<?php namespace TwswebInt\CamelotAuth\Auth;

use TwswebInt\CamelotAuth\Session\SessionInterface;
use TwswebInt\CamelotAuth\Cookie\CookieInterface;
use TwswebInt\ICamelotAuth\Database\DatabaseInterface;

class LocalAuth extends AbstractAuth{

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