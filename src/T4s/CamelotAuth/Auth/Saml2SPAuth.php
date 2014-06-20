<?php namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Auth\Saml2\Bindings\Binding;
use T4s\CamelotAuth\Auth\Saml2\Bindings\HTTPArtifactBinding;
use T4s\CamelotAuth\Auth\Saml2\Saml2Auth;


use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Events\DispatcherInterface;

use T4s\CamelotAuth\Auth\Saml2\Core\Messages\AuthnRequest;

use T4s\CamelotAuth\Auth\Saml2\Bindings\HTTPRedirectBinding;
use T4s\CamelotAuth\Storage\StorageDriver;

class Saml2SPAuth extends Saml2Auth implements AuthInterface
{


	public function __construct($provider,ConfigInterface $config,SessionInterface $session,CookieInterface $cookie,StorageDriver $storage,$path)
	{
		parent::__construct($provider,$config,$session,$cookie,$storage,$path);
	}

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
			throw new $exception("EntityID (".$this->provider.") is not registered with this Service Provider");				
		}


		if(strpos($this->path,'AssertionConsumingService') !== false)
		{
			// handle assertion message
			return $this->handleAsertionConsumingServiceRequest();
		}
		elseif(strrpos($this->path, 'SingleLogoutService') !== false)
		{
			// handle logout message
			return $this->handleSignoutRequest();
		}
		
		return $this->sendAuthenticationRequest();
	}


	public function register(array $accountDetails = array())
	{

	}

	public function logout()
	{

	}




	protected function sendAuthenticationRequest()
	{
		// lets start by getting the idp metadata
		$idpMetadata = $this->metadataStore->getEntityDescriptor($this->provider);//$this->storage->get('entity')->getEntity($this->provider);

		// create a new AuthRequest and send it to a idp
		$authnMessage = new AuthnRequest($idpMetadata,$this->getMyMetadata());

		$authnMessage->setAssertionConsumingServiceURL($this->callbackUrl.'/AssertionConsumingService');
		// where should we redirect the user after a successfull login 
		//$request->setRelayState($this->getRelayState());

		$request = new HTTPRedirectBinding();

		$request->send($authnMessage);
	}

	protected function handleAsertionConsumingServiceRequest()
	{
		$binding = Binding::getBinding();

		// if its a artifact response then we need to have the keys so lets inject them here
		if($binding instanceof HTTPArtifactBinding)
		{
			$binding->setSPMetadata($this->getMetadata());
		}
		// lets get the response message
		$response = $binding->receive();
		if(!($response instanceof ResponseMessage))
		{
			throw new \Exception("The Assertion Consuming Service has recieved an invalid message");
		}

		$this->provider = $response->getIssuer();
		if(is_null($this->provider))
		{
			throw new \Exception("the message recieved does not specify the issuer", 1);
			
		}

		
		
		var_dump($response->getNameId());

		var_dump($response->getAttributes());
	}
}