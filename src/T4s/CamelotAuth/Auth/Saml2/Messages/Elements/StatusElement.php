<?php namespace T4s\CamelotAuth\Auth\Saml2\Messages;

class StatusElement
{
	// required
	protected $statusCode = null
	// optional
	protected $message = null;
	// optional
	protected $detail = null;


	public function parseXML(\DOMElement $status)
	{
		
	}

	public function toXML(\DOMDocument $dom)
	{
		$statusElement = $dom->createElementNS(Saml2Constants::Namespace_SAMLProtocol,'samlp:Status');
		$statusElement->appendChild($this->statusCode->toXML($dom));
		if(is_null($this->message))
		{
			$statusMessage = $dom->createElementNS(Saml2Constants::Namespace_SAMLProtocol,'samlp:StatusMessage',$this->message);
			$statusElement->appendChild($statusMessage);
		}

		if(is_null($this->detail))
		{
			
		}

		return $statusElement;
	}
}