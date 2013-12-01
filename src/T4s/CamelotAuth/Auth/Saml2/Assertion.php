<?php namespace T4s\CamelotAuth\Auth\Saml2;

use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

use T4s\CamelotAuth\Auth\Saml2\XMLNodes\NameIDNode;
use T4s\CamelotAuth\Auth\Saml2\XMLNodes\SubjectConfirmationNode;

class Assertion 
{
	/**
	 * The Identifier for the request
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * The time the request is issued (eg now)
	 *
	 * @var dateTime
	 */
	protected $issueInstant;

	/**
	 * Identifies the entity that generated the message
	 *
	 * @var string
	 */
	protected $issuer = '';

	/**
	 * Specifies the name identifier of the subject in the assertion
	 *
	 * @var array|null
	 */
	protected $nameId = null;

	/**
	 * Encrypted name identifier of the subject
	 *
	 * @var array|null
	 */
	protected $encryptedNameId = null;

	/**
	 * Encrypted attributes
	 *
	 * @var array|null
	 */
	protected $encryptedAttributes = null;

	/**
	 * The earliest time this assertion is valid from as unix timestamp
	 *
	 * @var int
	 */
	protected $notBefore = 0;

	/**
	 * The time the assertion expires as a unix timestamp
	 *
	 * @var int 
	 */
	protected $notOnOrAfter = 0;

	/** 
	 * array of service providers allowed to recieve this 
	 *
	 * @var array|null
	 */
	protected $validAudience = null;

	/**
	 * the time this session is to expire 
	 *
	 * @var int|null
	 */
	protected $sessionNotOnOrAfter = null;

	/**
	 * the idp's session id for this user
	 *
	 * @var string|null
	 */
	protected $sessionIndex = null;

	/**
	 * The timestamp of when the user was authenticated 
	 *
	 * @var int
	 */
	protected $authInstant = null;

	/**
	 * The authentication context of this assertion
	 *
	 * @var string|null
	 */
	protected $authnnContext = null;

	/**
	 * an array of authenticating authorities for this assertion.
	 *
	 * @var array
	 */
	protected $authenticatingAuthorities = array();

	/**
	 * an array associated with attributes
	 *
	 * @var array
	 */
	protected $attributes = array();

	/**
	 * The NameFormat used on all the attributes
	 *
	 * @var string
	 */
	protected $nameFormat = null;

	/**
	 *  the private key we should use to sign this assertion
	 *
	 * @var object|null
	 */
	protected $signatureKey = null;

	/**
	 * an array of certificates that should be included in the assertion
	 *
	 * @var array
	 */
	protected $certificates = array();

	/**
	 * the data needed to verify the signature 
	 *
	 * @var array|null
	 */
	protected $signatureData = null;

	/**
	 * The SubjectConfirmation element of the assertion
	 *
	 * @var array
	 */
	protected $subjectConfirmation = array();

	public function __construct(\DOMElement $assertion = null)
	{
		$this->id = uniqid();
		$this->issueInstant = time();
		$this->authInstant = time();
		$this->nameFormat = Saml2Constants::NameFormat_Unspecified;

		if(!is_null($assertion))
		{
			return $this->importXMLAssertion($assertion);
		}
	}

	public function importXMLAssertion($assertion)
	{
		if(!$assertion->hasAttribute('ID'))
		{
			throw new \Exception("The SAML assertion is missing the ID attribute");
		}
		$this->id = $assertion->getAttribute('ID');

		if($assertion->getAttribute('Version') != '2.0')
		{
			throw new \Exception("Unsupported Version: ".$assertion->getAttribute('Version'));
		}

		$this->issueInstant = \DateTime::createFromFormat('Y-m-d\TH:i:s\Z',$assertion->getAttribute('IssueInstant'))->getTimestamp();

		$this->issuer = $this->getNode($assertion,'/saml:Issuer')->item(0)->nodeValue;

		$this->nameId = $this->getNode($assertion,'/saml:Assertion/saml:Subject/saml:NameID')->item(0)->nodeValue;


		$this->sessionNotOnOrAfter = $this->parseSessionNotOnOrAfter($assertion);

		$this->sessionIndex = $this->parseSessionIndex($assertion);

		$this->notBefore = strtotime($this->getNode($assertion,'/saml:Assertion/saml:Conditions[@NotBefore]')->item(0)->getAttribute('NotBefore'));


		$this->attributes = $this->parseAttributes($assertion);

	}

	protected function parseSessionNotOnOrAfter(\DOMElement $assertion)
	{
		$node =  $this->getNode($assertion,'/saml:Assertion/saml:AuthnStatement[@SessionNotOnOrAfter]');

		 if($node->length == 0)
		 {
		 	return null;
		 }

		 return strtotime($node->item(0)->getAttribute('SessionNotOnOrAfter'));
	}

	protected function parseSessionIndex(\DOMElement $assertion)
	{
		$node =  $this->getNode($assertion,'/saml:Assertion/saml:AuthnStatement[@SessionIndex]');

		 if($node->length == 0)
		 {
		 	return null;
		 }

		 return $node->item(0)->getAttribute('SessionIndex');
	}

	
	protected function parseAttributes(\DOMElement $assertion)
	{
		$node = $this->getNode($assertion,'/saml:Assertion/saml:AttributeStatement/saml:Attribute');

		$attributes = array();
		foreach ($node as $attributeNode) {
			$name = $attributeNode->attributes->getNamedItem('Name')->nodeValue;
			$values = array();
			foreach ($attributeNode->childNodes as $childAttribute)
			{
				if($childAttribute->nodeType == XML_ELEMENT_NODE && $childAttribute->tagName === 'saml:AttributeValue')
				{
					$values[] = $childAttribute->nodeValue;
				}
			}

			$attributes[$name] = $values;
		}

		return $attributes;
	}

	protected function getNode(\DOMElement $node ,$xpathQuery)
	{
		$xpath = new \DOMXPath($node->ownerDocument);
		$xpath->registerNamespace('samlp' , Saml2Constants::Namespace_SAMLProtocol);
        $xpath->registerNamespace('saml' , Saml2Constants::Namespace_SAML);
        $xpath->registerNamespace('ds' , 'http://www.w3.org/2000/09/xmldsig#');
	  	
	  	return $xpath->query('/samlp:Response'.$xpathQuery);
	}
}