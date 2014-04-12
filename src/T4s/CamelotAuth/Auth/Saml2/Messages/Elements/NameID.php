<?php 
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Messages\Elements;

class NameID
{
	protected $value;

	protected $nameQualifier = null;

	protected $spNameQualifier = null;

	protected $format = null;

	protected $spProvidedID = null;

	public function __construct($value)
	{
		$this->value = $value;
	}	


	public function toXML(\DOMElement $parentNode)
	{
		$n = $parentNode->ownerDocument->createElementNS(Saml2Constants::Namespace_SAML,'saml:NameID');
		$n->appendChild($parentNode->ownerDocument->createTextNode($this->value));
		$parentNode->appendChild($n);

		if(!is_null($this->nameQualifier))
		{
			$n->setAttribute('NameQualifier',$this->nameQualifier);
		}

		if(!is_null($this->spNameQualifier))
		{
			$n->setAttribute('SPNameQualifier',$this->spNameQualifier);
		}

		if(!is_null($this->format))
		{
			$n->setAttribute('Format',$this->format);
		}
	}

	public function importXML($xml)
	{
		if($xml->hasAttribute('NameQualifier'))
		{
			$this->nameQualifier = $xml->getAttribute('NameQualifier');
		}
		
		if($xml->hasAttribute('SPNameQualifier'))
		{
			$this->spNameQualifier = $xml->getAttribute('SPNameQualifier');
		}

		if($xml->hasAttribute('Format'))
		{
			$this->format = $xml->getAttribute('Format');
		}	

		$this->value = $this->getNode($xml,'/saml:NameID')->item(0)->nodeValue;	
	}

	protected function getNode(\DOMElement $node ,$xpathQuery)
	{
		$xpath = new \DOMXPath($node->ownerDocument);
		$xpath->registerNamespace('samlp' , Saml2Constants::Namespace_SAMLProtocol);
        $xpath->registerNamespace('saml' , Saml2Constants::Namespace_SAML);
        $xpath->registerNamespace('ds' , 'http://www.w3.org/2000/09/xmldsig#');
	  	
	  	return $xpath->query($xpathQuery);
	}
}