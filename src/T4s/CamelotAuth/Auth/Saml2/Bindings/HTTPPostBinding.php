<?php namespace T4s\CamelotAuth\Auth\Saml2\bindings;

use T4s\CamelotAuth\Auth\Saml2\Messages\AbstractMessage;
use T4s\CamelotAuth\Auth\Saml2\bindings\Binding;
/**
* 
*/
class HTTPPostBinding extends Binding
{

	public function send(AbstractMessage $message)
	{

	}

	public function receive()
	{
		if(array_key_exists('SAMLRequest',$_POST))
		{
			$message = $_POST['SAMLRequest'];
		}
		else if(array_key_exists('SAMLResponse', $_POST))
		{
			$message = $_POST['SAMLResponse'];
		}
		else
		{
			throw new \Exception("Request is missing a SAMLResponse or SAMLRequest Parameter");
		}

		$message = base64_decode($message);

		$document = new \DOMDocument();
		$document->loadXML($message);

		$message = AbstractMessage::getMessageFromXML($document->firstChild);
		
		if(array_key_exists('RelayState',$_POST))
		{
			$message->setRelayState($_POST('RelayState'));
		}

		return $message;
	}
}