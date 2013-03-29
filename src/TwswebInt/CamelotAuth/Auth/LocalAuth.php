<?php namespace TwswebInt\CamelotAuth\Auth;

use TwswebInt\CamelotAuth\Session\SessionInterface;
use TwswebInt\CamelotAuth\Cookie\CookieInterface;
use TwswebInt\CamelotAuth\Database\DatabaseInterface;

class LocalAuth extends AbstractAuth{

	public function authenticate()
	{
		/*$oauthUser = $this->database->createModel('oauth2User');
		var_dump($oauthUser->find(1));

		*/
		
	}


	public function register()
	{

	}
}