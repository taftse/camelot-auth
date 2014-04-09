<?php namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Auth\Saml2\Saml2Auth;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Messaging\MessagingInterface;
use T4s\CamelotAuth\Events\DispatcherInterface;

use T4s\CamelotAuth\Auth\Saml2\Messages\AuthnRequestMessage;
use T4s\CamelotAuth\Auth\Saml2\Messages\ResponseMessage;

use T4s\CamelotAuth\Auth\Saml2\bindings\Binding;
use T4s\CamelotAuth\Auth\Saml2\bindings\HTTPRedirectBinding;

class Saml2IDPAuth extends Saml2Auth implements AuthInterface
{


	public $supportedBindings = [Saml2Constants::Binding_HTTP_POST];

	public $idpMetadata = null;

	public function authenticate(array $credentials = null, $remember = false,$login = true)
	{
		
		// check if a idp entity id is set in the credentails
		if(isset($credentials['entityID']))
		{
			// override the provider
			$this->provider = $credentials['entityID'];
		}
		// check if the entity provider is valid
		

		return $this->handleRequest();
		

	}

	public function handleRequest()
	{
		$binding  = Binding::getBinding();
		$request =  $binding->receive();

		if(!($request instanceof AuthnRequestMessage))
		{
			throw new Exception("not a saml AuthnRequestMessage");
			
		}

		$this->provider = $request->getIssuer();

		if(!$this->metadataStore->isValidEnitity($this->provider))
		{
			$exception = 'T4s\CamelotAuth\Auth\Saml2\Exceptions\EntityNotFoundException';
			throw new $exception("EntityID (".$this->provider.") is not registered with this Identity Provider");				
		}
		
		$acsEndpoint = $this->getAssertionConsumingService(
				$this->metadataStore->getEntity($this->provider),
				$request->getAssertionConsumingServiceURL(),
				$request->getProtocolBinding(),
				$request->getAssertionConsumingServiceIndex());
		
		var_dump($this->generateResponseMessage($acsEndpoint)->generateUnsignedMessage());
		die();
	}

	public function getAssertionConsumingService($spMetadata,$acsURL,$binding,$index)
	{
		
		$firstAllowed  = null;
		$firstNotFalse = null;
		$returnEndpoint = null;

		foreach ($spMetadata->getEndpoints('AssertionConsumingService') as $endpoint) {
			if(!is_null($acsURL) && $endpoint['Location'] !== $acsURL)
			{
				continue;
			}

			if(!is_null($binding) && $endpoint['Binding'] !== $binding)
			{
				continue;
			}

			if(!is_null($index) && $endpoint['Index'] !== $index)
			{
				continue;
			}

			if(!in_array($endpoint['Binding'],$this->supportedBindings))
			{
				continue;
			}

			if(array_key_exists('isDefault',$endpoint))
			{
				if($endpoint['isDefault'] == true)
				{
					return $endpoint;
				}
				
				if(is_null($firstAllowed))
				{
					$firstAllowed = $endpoint;
				}
			}
			else if(is_null($firstNotFalse))
			{
				$firstNotFalse = $endpoint;
			}		
		}

		if(!is_null($firstNotFalse) && is_null($returnEndpoint))
		{
			return $firstNotFalse;
		}
		elseif(is_null($returnEndpoint))
		{
			return $firstAllowed;
		}
		
		return $spMetadata->getDefaultEndpoint('AssertionConsumingService',$this->supportedBindings);

		
	}

	public function generateResponseMessage($consumerURL)
	{
		$responseMessage = new ResponseMessage();
		$responseMessage->setIssuer($this->config->get('myEntityID'));
		$responseMessage->setDestination($consumerURL);
		//$responseMessage->addSignature($this->metadataStore->getEntity($this->provider));

		return $responseMessage;
	}
}