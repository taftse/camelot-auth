<?php namespace T4s\CamelotAuth\Auth\Saml2\XMLNodes;

use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;
use DOMElement;


class NameIDNode 
{
	
	protected $nameQualifier = null;

	protected $SPNameQualifier = null;

	protected $format = null;

	protected $SPProvidedID = null;

	protected $value = null;

	protected $node = null;

	protected $encryptedID = null;

	public function __construct(DOMElement $element)
	{
		



		die();
		$nameId = $element->ownerDocument->getElementsByTagNameNS(Saml2Constants::Namespace_SAML,'NameID');

		if($nameId->length > 1)
		{
			for($i = 0;$i <$nameId->length;$i++)
			{
				$this->node[] = new NameIDNode($nameId->item($i));
			}
			return;
		}
		else if($nameId->length < 1)
		{
			$encryptedID = $element->ownerDocument->getElementsByTagNameNS(Saml2Constants::Namespace_SAML,'EncryptedID')
														->getElementsByTagNameNS('xenc','EncryptedData');
			
			for($i = 0;$i <$nameId->length;$i++)
			{
				$this->encryptedID[] = $encryptedID;
			}
			return;	
						
		}

		if($nameId->hasAttribute('NameQualifier'))
		{
			$this->nameQualifier = $nameId->getAttribute('NameQualifier');
		}

		if($nameId->hasAttribute('SPNameQualifier'))
		{
			$this->SPNameQualifier = $nameId->getAttribute('SPNameQualifier');
		}

		if($nameId->hasAttribute('Format'))
		{
			$this->format = $nameId->getAttribute('Format');
		}

		if($nameId->hasAttribute('SPProvidedID'))
		{
			$this->SPProvidedID = $nameId->getAttribute('SPProvidedID');
		}	

		$value = $nameId->textContent;


	}

	public function getNameID()
	{
		if($this->isEncrypted())
		{
			return $this->encryptedNameID;
		}
		
		return $this->node;
	}

	public function isEncrypted()
	{
		if(is_null($this->encryptedNameID))
		{
			return false;
		}
		
		return true;
	}
}