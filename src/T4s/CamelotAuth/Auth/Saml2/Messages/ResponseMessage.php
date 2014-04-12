<?php namespace T4s\CamelotAuth\Auth\Saml2\Messages;

use T4s\CamelotAuth\Auth\Saml2\Messages\AbstractMessage;
use T4s\CamelotAuth\Auth\Saml2\Metadata\EntityMetadata;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

use T4s\CamelotAuth\Auth\Saml2\Assertion;

class ResponseMessage extends AbstractMessage
{
	

	// attributes 

	protected $inResponseTo = null;


	//elements

	protected $status = null;


	/**
	 * A list of all the assertions in this response
	 *
	 * @var array
	 */
	protected $assertions = array();


	public function __construct($message = null,EntityMetadata $spMetadata = null)
	{
		parent::__construct('Response',$message);
		
		if(is_null($message))
		{
			return;
		}

		if($message instanceof EntityMetadata)
		{
			$this->importMetadataSettings($message,$spMetadata);
		}
	}
	
	public function importXMLMessage(\DOMElement $message)
	{
		parent::importXMLMessage($message);
		
		foreach ($message->childNodes as $node) {
			
			if($node->namespaceURI != Saml2Constants::Namespace_SAML)
			{
				continue;
			}

			if($node->localName == "Assertion")
			{
				$this->assertions[] = new Assertion($node);
			}
			else if($node->localName == "EncryptedAssertion")
			{
				$this->assertions[] = new EncryptedAssertion($node);
			}
		}
	}

	public function getAssertions()
	{
		return $this->assertions;
	}

	public function setAssertions(array $assertions)
	{
		$this->assertions = $assertions;
	}

	public function addAssertion(Assertion $assertion)
	{
		$this->assertions[] = $assertion;
	}


	public function getNameId()
	{
		foreach ($this->assertions as $assertion) {
			if(isset($assertion->nameId))
			{
				return $assertion->nameId;
			}
		}
	}

	public function getAttributes()
	{
		$attributes = array();
		foreach ($this->assertions as $assertion) {
			if(isset($assertion->attributes))
			{
				return $this->attributes;
			}
		}
	}

	public function getInResponseTo()
	{
		return $this->inResponseTo;
	}

	public function setInResponseTo($inResponseTo)
	{
		$this->inResponseTo = $inResponseTo;
	}

	public function generateUnsignedMessage()
	{	
		$root = parent::generateUnsignedMessage();

		foreach ($this->assertions as $assertion) {
			$assertion->generateXML($root)
		}
		return $root;
	}


}