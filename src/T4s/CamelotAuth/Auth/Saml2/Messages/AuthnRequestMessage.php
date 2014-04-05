<?php namespace T4s\CamelotAuth\Auth\Saml2\Messages;

use T4s\CamelotAuth\Auth\Saml2\Messages\AbstractMessage;
use T4s\CamelotAuth\Auth\Saml2\Metadata\EntityMetadata;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

class AuthnRequestMessage extends AbstractMessage
{
	/**
	 * Specifies the requested subject of the resulting assertion(s)
	 *
	 * @var string|null
	 */
	protected $subject = null;

	/**
	 * Specifies constraints on the name identifier to be used to represent the requested subject
	 *
	 * @var array|null
	 */
	protected $nameIDPolicy = null;

	/**
	 * Specifies the SAML conditions the requester expects to limit the validity and/or 
	 * use of the resulting assertions
	 * 
	 * @var string|null
	 */
	protected $conditions = null;

	/**
	 * specifies the requirements, if any that the requester places on the authentication context 
	 *
	 * @var array|null
	 */
	protected $requestedAuthContext = null;

	/**
	 * Specifies a set of identity providers trusted by the requester to authenticate the user
	 *
	 * @var string|null
	 */
	protected $scoping = null;

	/**
	 * a value to determain if the idp must re-authenticate the user 
	 *
	 * @var boolean
	 */
	protected $forceAuthn = false;

	/**
	 * value to detrmain if the idp or useragent can take visable controll
	 * 
	 * @var boolean
	 */
	protected $isPassive = false;


	/**
	 * indicates the id of the assertion consumer service that should be used to send the respons message to 
	 *
	 * @var int|null
	 */
	protected $assertionConsumerServiceIndex = null;

	/**
	 * indicates the url of the assertion consumer service where the response message should be sent
	 *
	 * @var string|null
	 */
	protected $assertionConsumerServiceURL = null;

	/**
	 * tells the idp what protocol binding should be used to send when returning the response message
	 *
	 * @var string|null
	 */
	protected $protocolBinding = null;


	protected $bindingOptions = array(	Saml2Constants::Binding_HTTP_POST,
										Saml2Constants::Binding_HOK_SSO,
										Saml2Constants::Binding_HTTP_Artifact,
										Saml2Constants::Binding_HTTP_Redirect
									 );

	/**
	 * indicates the id of the attribute consuming service to be used for the response message
	 *
	 * @var int|null
	 */
	protected $attributeConsumingServiceIndex = null;

	/**
	 * specifies the human readable name of the sp 
	 *
	 * @var string|null
	 */
	protected $providerName = null;

	/**
	 * Specifies if the request should be signed before sending
	 *
	 * @var bool
	 */
	protected $signRequest = false;


	public function __construct($message = null,EntityMetadata $spMetadata = null)
	{
		parent::__construct('AuthnRequest',$message);
		
		if(is_null($message))
		{
			return;
		}

		if($message instanceof EntityMetadata)
		{
			$this->importMetadataSettings($message,$spMetadata);
		}
		else if($message instanceof \DOMElement)
		{
			$this->importXMLMessage($message);
		}
	}
	
	public function importMetadataSettings(EntityMetadata  $idpMetadata,EntityMetadata $spMetadata)
	{
		$this->nameIDPolicy = array(
			'Format'=>$spMetadata->getAttribute('NameIDFormat',Saml2Constants::NameID_Transient),
			'AllowCreate' => TRUE);
		
		$this->forceAuthn = $spMetadata->getAttribute('ForceAuthn',FALSE);
		$this->isPassive = $spMetadata->getAttribute('IsPassive',FALSE);

		
		$this->protocolBinding = $spMetadata->getValidatedValue('ProtocolBinding',$this->bindingOptions,Saml2Constants::Binding_HTTP_POST);

		if($this->protocolBinding === Saml2Constants::Binding_HOK_SSO)
		{
			$destination = $idpMetadata->getDefaultEndpoint('SingleSignOnService',array(Saml2Constants::Binding_HOK_SSO));
		}
		else
		{
			$destination = $idpMetadata->getDefaultEndpoint('SingleSignOnService',array(Saml2Constants::Binding_HTTP_Redirect));
		}
		$this->destination = $destination['Location'];
		$this->issuer = $spMetadata->getEntityID();

		#@todo Add Support for AuthnContextClassRef in AuthnRequest (GH issue #22)
		
		$signRequest = false;

		if(isset($spMetadata->getDescriptor('SPSSODescriptor')['AuthnRequestSigned']))
		{
			$this->signRequest = $spMetadata->getDescriptor('SPSSODescriptor')['AuthnRequestSigned'];
		}
		if($this->signRequest == false && isset($idpMetadata->getDescriptor('IDPSSODescriptor')['WantAuthnRequestSigned']))
		{
			$this->signRequest = $idpMetadata->getDescriptor('IDPSSODescriptor')['WantAuthnRequestSigned'];
		}
	}

	public function importXMLMessage(\DOMElement $message)
	{
		if($message->hasAttribute('ForceAuthn')&& $message->getAttribute('ForceAuthn') == 'true')
		{
			$this->forceAuthn = true;
		}

		if($message->hasAttribute('IsPassive')&& $message->getAttribute('IsPassive') == 'true')
		{
			$this->isPassive = true;
		}

		if($message->hasAttribute('AssertionConsumerServiceURL'))
		{
			$this->assertionConsumerServiceURL = $message->getAttribute('AssertionConsumerServiceURL');
		}

		if($message->hasAttribute('AssertionConsumerServiceIndex'))
		{
			$this->assertionConsumerServiceIndex = (int)$message->getAttribute('AssertionConsumerServiceIndex');
		}

		if($message->hasAttribute('ProtocolBinding'))
		{
			$this->protocolBinding = $message->getAttribute('ProtocolBinding');
		}

		$this->nameIDPolicy = $this->parseNameIDPolicy($message);

		$this->requestedAuthContext = $this->parseRequestdAuthnContext($message);

		$this->scoping = $this->parseScoping($message);


	}

	public function signRequest()
	{
		return $this->signRequest;
	}

	public function generateUnsignedMessage()
	{
		$root = parent::generateUnsignedMessage();

		// if true
		if($this->forceAuthn)
		{
			$root->setAttribute('ForceAuthn','true');
		}

		// if true
		if($this->isPassive)
		{
			$root->setAttribute('IsPassive','true');
		}

		if(!is_null($this->assertionConsumerServiceURL))
		{
			$root->setAttribute('AssertionConsumerServiceURL',$this->assertionConsumerServiceURL);
		}

		if(!is_null($this->assertionConsumerServiceIndex))
		{
			$root->setAttribute('AssertionConsumerServiceIndex',$this->assertionConsumerServiceIndex);
		}

		if(!is_null($this->protocolBinding))
		{
			$root->setAttribute('ProtocolBinding',$this->protocolBinding);
		}

		//<NameIDPolicy/>
		$root->appendChild($this->generateNameIDPolicy());

		// <RequestedAuthn/>
		$root = $this->generateRequestdAuthnContext($root);
		

		//<extentions> @todo add extensions support
		if(!empty($this->extensions))
		{
			$this->getExtentionsList($root);
		}

		// <scoping>
		if(!empty($this->scoping))
		{
			$scoping = $this->xmlMessage->createElementNS(Saml2Constants::Namespace_SAMLProtocol,'Scoping');
			if(!is_null($this->scoping['ProxyCount']))
			{
				$scoping->setAttribute('ProxyCount',$this->scoping['ProxyCount']);
			}

			if(isset($this->scoping['IDPList']) && count($this->scoping['IDPList']) > 0)
			{
				$idpList= $this->xmlMessage->createElementNS(Saml2Constants::Namespace_SAMLProtocol,'IDPList');

				foreach ($this->scoping['IDPList'] as $idp)
				{
					$idEntity = $this->xmlMessage->createElementNS(Saml2Constants::Namespace_SAMLProtocol,'IDPEntity');
					$idEntity->setAttribute('ProviderID',$idp);
					$idpList->appendChild($idEntity);
				}
				$scoping->appendChild($idpList);
				$root->appendChild($scoping);
			}

			if(isset($this->scoping['RequesterID']) && count($this->scoping['RequesterID']) > 0)
			{
				foreach ($this->scoping['RequesterID'] as $index => $value) 
				{
					$requester = $this->xmlMessage->createElementNS(Saml2Constants::Namespace_SAMLProtocol,'RequesterID');
					$requester->appendChild($this->xmlMessage->createTextNode($value));
					$scoping->appendChild($requester);
				}			
			}
		}
		return $root;
	}	

	// set the url of the assertion consuming service for this sp
	public function setAssertionConsumingServiceURL($url)
	{
		$this->assertionConsumerServiceURL = $url;
	}

	// gets the url of the assertion consuming service for this sp
	public function getAssertionConsumingServiceURL($url)
	{
		return $this->assertionConsumerServiceURL;
	}

	public function generateNameIDPolicy()
	{
		if(!empty($this->nameIDPolicy))
		{
			$nameIDPolicy = $this->xmlMessage->createElementNS(Saml2Constants::Namespace_SAMLProtocol,'NameIDPolicy');
			
			if(array_key_exists('Format',$this->nameIDPolicy))
			{
				$nameIDPolicy->setAttribute('Format',$this->nameIDPolicy['Format']);
			}

			if(array_key_exists('SPNameQualifier', $this->nameIDPolicy))
			{
				$nameIDPolicy->setAttribute('SPNameQualifier',$this->nameIDPolicy['SPNameQualifier']);
			}

			if(array_key_exists('AllowCreate', $this->nameIDPolicy))
			{
				$nameIDPolicy->setAttribute('AllowCreate',$this->nameIDPolicy['AllowCreate']);
			}

			return $nameIDPolicy;
		}
	}

	protected function parseNameIDPolicy(\DOMElement $message)
	{
		$nameIDPolicy = $message->ownerDocument->getElementsByTagNameNS(Saml2Constants::Namespace_SAMLProtocol, 'NameIDPolicy')->item(0);
		
		if(!empty($nameIDPolicy))
		{
			if($nameIDPolicy->hasAttribute('Format'))
			{
				$return['Format'] = $nameIDPolicy->getAttribute('Format');
			}

			if($nameIDPolicy->hasAttribute('SPNameQualifier'))
			{
				$return['SPNameQualifier'] = $nameIDPolicy->getAttribute('SPNameQualifier');
			}

			if($nameIDPolicy->hasAttribute('AllowCreate'))
			{
				$return['AllowCreate'] = $nameIDPolicy->getAttribute('AllowCreate');
			}	
			return $return;
		}
	}

	protected function generateRequestdAuthnContext($root)
	{
		if(!empty($this->requestedAuthContext['AuthnContextClassRef']))
		{
			$requestedAuthContext = $this->xmlMessage->createElementNS(Saml2Constants::Namespace_SAMLProtocol,'RequestedAuthnContext');
			

			if(isset($this->requestedAuthContext['Comparison']) && $this->requestedAuthContext['Comparison'] !== 'exact')
			{
				$requestedAuthContext->setAttribute('Comparison',$this->requestedAuthContext['Comparison']);
			}

			$root->appendChild($requestedAuthContext);

			foreach ($this->requestedAuthContext['AuthnContextClassRef'] as $AuthnContext)
			{
				$context = $this->xmlMessage->createElementNS(Saml2Constants::Namespace_SAML,'AuthnContextClassRef');
				$context->appendChild($this->xmlMessage->createTextNode($AuthnContext));
				$root->appendChild($context);				
			}
		}
	}

	protected function parseRequestdAuthnContext(\DOMElement $message)
	{
		$requestedAuthContext = $message->ownerDocument->getElementsByTagNameNS(Saml2Constants::Namespace_SAMLProtocol, 'RequestedAuthnContext')->item(0);
		if(!empty($requestedAuthContext))
		{
			$return['AuthnContextClassRef'] = [];
			$return['Comparison'] = 'exact';

			if($requestedAuthContext->hasAttribute('Comparison'))
			{
				$return['Comparison'] = $requestedAuthContext->getAttribute('Comparison');
			}

			$accr =  $message->ownerDocument->getElementsByTagNameNS(Saml2Constants::Namespace_SAML,'AuthnContextClassRef')->item(0);
			foreach ($accr as $i) {
				$return['AuthnContextClassRef'][] = trim($i->textContent);
			}

			return $return;
		}
	}

	protected function generateScoping()
	{

	}

	protected function parseScoping(\DOMElement $message)
	{
		$scoping =  $message->ownerDocument->getElementsByTagNameNS(Saml2Constants::Namespace_SAMLProtocol,'Scoping')->item(0);
		if(!empty($scoping))
		{
			throw new Exception("parseScoping function not complete yet");
		}
	}
	/*public function setProtocolBinding($binding)
	{
		if(!in_array($binding, $this->bindingOptions))
		{
			throw new \Exception("binding value is not one of the supported bindings");
		}
		$this->protocolBinding = $binding;
	}*/
}