<?php namespace T4s\CamelotAuth\Auth\Saml2\Messages;

use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;
use T4s\CamelotAuth\Auth\Saml2\Metadata\EntityMetadata;

abstract class AbstractMessage implements SignedElementInterface
{
	// Attributes

	/**
	 * The Identifier for the request
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * The Version of the request
	 * 
	 * @var int
	 */
	protected $version = '2.0';

	/**
	 * The time the request is issued (eg now)
	 *
	 * @var dateTime
	 */
	protected $issueInstant;

	/**
	 * the uri from which this request has been sent
	 * (optional)
	 *
	 * @var string|null
	 */
	protected $destination = null;

	/**
	 * indicates if consent was obtained from the user 
	 * (optional)
	 * 
	 * @var string
	 */
	protected $consent = Saml2Constants::Consent_Unspecified;


	//elements

	/**
	 * Identifies the entity that generated the message
	 *
	 * @var string
	 */
	protected $issuer = null;


	private $signatureKey = null;

	private $certificates = null;

	private $validators = null;



	protected $extensions = null;

	// end elements


	protected $messageType;

	protected $xmlMessage= null;


	public function __construct($messageType,$message = null)
	{
		$this->xmlMessage = new \DOMDocument();
		$this->messageType = $messageType;
		$this->id = uniqid();
		$this->issueInstant = time();

		if(is_null($message))
		{
			return;
		}

		if($message instanceof \DOMElement)
		{
			return $this->importXMLMessage($message);
		}
	}

	/**
	 * Converts a XML Message into a SAML Message
	 *
	 * @param DOMElement $message
	 * @return AbstractMessage
	 * @throws Exception
	 */
	public static function getMessageFromXML(\DOMElement $message)
	{
		if($message->namespaceURI != Saml2Constants::Namespace_SAMLProtocol)
		{
			throw new \Exception("Unknown saml request namespace:".$message->namespaceURI);
		}

		switch ($message->localName) {
			case 'AttributeQuery':
				return new AttributeQueryMessage($message);
				break;
			case 'AuthnRequest':
				return new AuthnRequestMessage($message);
				break;
			case 'LogoutResponse':
				return new LogoutResponseMessage($message);
				break;
			case 'LogoutRequest':
				return new LogoutRequestMessage($message);
				break;
			case 'Response':
				return new ResponseMessage($message);
				break;
			case 'ArtifactResponse':
				return new ArtifactResponseMessage($message);
				break;
			case 'ArtifactResolve':
				return new ArtifactResolveMessage($message);
				break;
			default:
				throw new \Exception("Unknown message Type (".$message->localName.")");
				break;
		}
	}

	public function generateUnsignedMessage()
	{
		$root = $this->xmlMessage->createElementNS(Saml2Constants::Namespace_SAMLProtocol,'samlp:'.$this->messageType);

		$this->xmlMessage->appendChild($root);

		$root->setAttribute('ID',$this->id);
		$root->setAttribute('Version',$this->version);
		$root->setAttribute('IssueInstant',date('Y-m-d\TH:i:s\Z',$this->issueInstant));

		if(!is_null($this->destination))
		{
			$root->setAttribute('Destination',$this->destination);
		}

		if(!is_null($this->issuer))
		{
			$n = $root->ownerDocument->createElementNS(Saml2Constants::Namespace_SAML,'saml:Issuer');
			$n->appendChild($root->ownerDocument->createTextNode($this->issuer));
			$root->appendChild($n);
		}
		
		return $root;
	}

	public function getExtentionsList(\DOMElement $parent)
	{
		if(!empty($this->extensions))
		{
			$extensions = $this->xmlMessage->createElementNS(Saml2Constants::Namespace_SAMLProtocol,'samlp:Extensions');
			$root->appendChild($extensions);

			foreach ($this->extensions as $extension) {
				
			}
		}
	}

	public function getDestination()
	{
		return $this->destination;
	}

	public function setDestination($destination)
	{
		$this->destination = $destination;
	}

	public function getXMLMessage()
	{
		return $this->xmlMessage;
	}

	public function getIssuer()
	{
		return $this->issuer;
	}
	
	public function setIssuer($issuer)
	{
		$this->issuer = $issuer;
	}

	public function importXMLMessage(\DOMElement $message)
	{
		if(!$message->hasAttribute('ID'))
		{
			throw new \Exception("The SAML message is missing the ID attribute");
		}
		$this->id = $message->getAttribute('ID');

		if($message->getAttribute('Version') != '2.0')
		{
			throw new Exception("Unsupported Version: ".$message->getAttribute('Version'));
		}

		$this->issueInstant = \DateTime::createFromFormat('Y-m-d\TH:i:s\Z',$message->getAttribute('IssueInstant'))->getTimestamp();


		if(!$message->hasAttribute('Destination'))
		{
			$this->destination = $message->getAttribute('Destination');
		}

		$this->issuer = $message->ownerDocument->getElementsByTagNameNS(Saml2Constants::Namespace_SAML, 'Issuer')->item(0)->nodeValue;
		
		$this->validateSignature($message);


	}

	protected function validateSignature(\DOMElement $message)
	{
		/*$xmlSecurity = new \XMLSecurityDSig();

		$signatureElement = $message->ownerDocument->getElementsByTagNameNS('http://www.w3.org/2000/09/xmldsig#','Signatures');
		
		//var_dump($signatureElement);
		//if($signatureElement)*/
	}


	public function getSignatureKey()
	{
		return $this->signatureKey;
	}

	public function setSignatureKey(\XMLSecurityKey $signatureKey)
	{
		$this->signatureKey = $signatureKey;
	}

	public function setCertificates(array $certificates)
	{
		$this->certificates = $certificates;
	}

	public function getCertificates()
	{
		return $this->certificates;
	}

	public function validate(\XMLSecurityKey $key)
	{
		
	}

	public static function addSignature(EntityMetadata $senderMetadata,EntityMetadata $recipientMetadata,SignedElementInterface $element)
	{
		
	}
}