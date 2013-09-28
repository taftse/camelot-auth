<?php namespace T4s\CamelotAuth\Auth;

class Oauth2ClientAuth extends AbstractAuth implements AuthInterface{


	public function __construct(ConfigInterface $config,SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,$provider)
	{
			parent::__construct($config,$session,$cookie,$database);

			$this->oauthProvider = $this->database->loadRepository('User',$this->config->get('oauth2camelot.model'));
			

			if(isset($providerName))
	}


}