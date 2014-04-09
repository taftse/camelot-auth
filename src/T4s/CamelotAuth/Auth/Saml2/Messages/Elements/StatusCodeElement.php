<?php namespace T4s\CamelotAuth\Auth\Saml2\Messages\Elements;

use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

class StatusCodeElement
{
	// required
	protected $value = null;
	// optional
	protected $statusCode = null;


	public function __construct($value = null,$statusCode = null)
	{
		if($value instanceof \DOMElement)
		{
			return $this->parseXML($value);
		}
		
		$this->value = $value;

		if(is_array($statusCode))
		{
			$this->statusCode = $statusCode;
		}
		else if(!is_null($statusCode))
		{
			$this->addStatusCode($statusCode);
		}
		
	}


	public function addStatusCode($statusCode)
	{
		$this->statusCode[] = $statusCode;
	}


	public function parseXML(\DOMElement $statusCode)
	{
		$this->value = $statusCode->getAttribute('Value');

		$statusCode = $message->ownerDocument->getElementsByTagNameNS(Saml2Constants::Namespace_SAMLProtocol,'StatusCode')->item(0);
		foreach ($statusCode as $statusCodeElement) {
			 $this->statusCode[] = new StatusCodeElement($statusCodeElement);
		}
	}

	public function toXML(\DOMDocument $dom)
	{
		$statusCodeElement = $dom->createElementNS(Saml2Constants::Namespace_SAMLProtocol,'samlp:StatusCode');
		$statusCodeElement->setAttribute("Value", $this->value);
		if(!is_null($this->statusCode))
		{
			foreach($this->statusCode as $statusCode)
			{
				$statusCodeElement->appendChild($statusCode->toXML($dom));
			}
		}
		return $statusCodeElement;
	}
}