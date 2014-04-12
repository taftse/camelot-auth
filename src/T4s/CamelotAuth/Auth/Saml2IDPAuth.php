<?php namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Auth\Saml2\Saml2Auth;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Messaging\MessagingInterface;
use T4s\CamelotAuth\Events\DispatcherInterface;

use T4s\CamelotAuth\Auth\Saml2\Metadata\IndexedEndpointType;

use T4s\CamelotAuth\Auth\Saml2\Messages\AuthnRequestMessage;
use T4s\CamelotAuth\Auth\Saml2\Messages\ResponseMessage;

use T4s\CamelotAuth\Auth\Saml2\bindings\Binding;
use T4s\CamelotAuth\Auth\Saml2\bindings\HTTPRedirectBinding;
use T4s\CamelotAuth\Auth\Saml2\bindings\HTTPPostBinding;
use T4s\CamelotAuth\Auth\Saml2\bindings\HTTPArtifactBinding;


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
		
		if(strpos($this->path,'SingleLogoutService'))
		{
			return $this->handleSingleLogoutRequest();
		}
		return $this->handleAuthnRequest();
		
	}

	public function handleAuthnRequest()
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
		

	
		switch($acsEndpoint->getBinding())
		{
			case Saml2Constants::Binding_HTTP_POST:
				$response = new HTTPPostBinding();
				break;
			case Saml2Constants::Binding_HTTP_Artifact:
				$response = new HTTPArtifactBinding();
				break;
			case Saml2Constants::Binding_HTTP_Redirect:
				$response = new HTTPRedirectBinding();
				break;
			default:
				throw new \Exception("Unsuported Binding (".$acsEndpoint->getBinding().")");
				
		}

		return $response->send($this->generateResponseMessage($acsEndpoint));
	}

	public function getAssertionConsumingService($spMetadata,$acsURL,$binding,$index)
	{
		
		$firstAllowed  = null;
		$firstNotFalse = null;
		
		foreach ($spMetadata->getEndpoints('AssertionConsumerService') as $endpointIndex =>$endpoint) {
			if(!isset($endpoint['Index']))
			{
				$endpoint['Index'] =  $endpointIndex;
			}

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
					return new IndexedEndpointType($endpoint['Binding'],$endpoint['Location'],$endpoint['Index'],true);
				}
				
				if(is_null($firstAllowed))
				{
					$firstAllowed = new IndexedEndpointType($endpoint['Binding'],$endpoint['Location'],$endpoint['Index']);
				}
			}
			else if(is_null($firstNotFalse))
			{
				$firstNotFalse = new IndexedEndpointType($endpoint['Binding'],$endpoint['Location'],$endpoint['Index']);
			}		
		}

		if(!is_null($firstNotFalse))
		{
			return $firstNotFalse;
		}
		elseif(!is_null($firstAllowed))
		{
			return $firstAllowed;
		}
		
		$endpoint = $spMetadata->getDefaultEndpoint('AssertionConsumingService',$this->supportedBindings);
		return new IndexedEndpointType($endpoint['Binding'],$endpoint['Location'],$endpoint['Index']);

		
	}

	public function generateResponseMessage($consumerEndpoint)
	{
		$responseMessage = new ResponseMessage();
		$responseMessage->setIssuer($this->config->get('myEntityID'));
		$responseMessage->setDestination($consumerEndpoint->getLocation());
		$responseMessage->addSignature($this->metadataStore->getEntity($this->provider));

		return $responseMessage;
	}
}