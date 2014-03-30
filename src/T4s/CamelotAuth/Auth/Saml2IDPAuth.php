<?php namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Auth\Saml2\Saml2Auth;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Messaging\MessagingInterface;
use T4s\CamelotAuth\Events\DispatcherInterface;

use T4s\CamelotAuth\Auth\Saml2\Messages\AuthRequestMessage;
use T4s\CamelotAuth\Auth\Saml2\Messages\ResponseMessage;

use T4s\CamelotAuth\Auth\Saml2\bindings\Binding;
use T4s\CamelotAuth\Auth\Saml2\bindings\HTTPRedirectBinding;

class Saml2IDPAuth extends Saml2Auth implements AuthInterface
{
	public function authenticate(array $credentials = null, $remember = false,$login = true)
	{

		
		// if user is logged in 
		if(!is_null($this->user()))
		{
			//redirect to dashboard
			return true;
		}
		// check if a idp entity id is set in the credentails
		if(isset($credentials['entityID']))
		{
			// override the provider
			$this->provider = $credentials['entityID'];
		}
		// check if the entity provider is valid
		if(!$this->metadataStore->isValidEnitity($this->provider))
		{
			$exception = 'T4s\CamelotAuth\Auth\Saml2\Exceptions\EntityNotFoundException';
			throw new $exception("EntityID (".$this->provider.") is not registered with this Identity Provider");				
		}

		if(strrpos($this->path,'Authn'))
		{
			return $this->handleAuthnRequest();
		}

	}

	public function handleAuthnRequest()
	{
		$binding  = Binding::getBinding();

		$response =  $binding->receive();

		var_dump($response);
	}
}