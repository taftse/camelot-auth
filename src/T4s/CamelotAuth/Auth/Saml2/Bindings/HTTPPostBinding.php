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
		if(is_null($this->destination))
		{
			$this->destination = $message->getDestination();
		}

		$messageString = $message->generateSignedMessage();
		$messageString = $message->getXMLMessage()->saveXML($messageString);
		$messageString = base64_encode($messageString);

		if($message instanceof RequestMessage)
		{
			$messageType = 'SAMLRequest';
		}
		else
		{
			$messageType = 'SAMLResponse';
		}

		$post[$messageType] = $messageString;
		if(!is_null($message->getRelayState()))
		{
			$post['RelayState'] = $message->getRelayState();
		}

		//header('Location: ' . $this->destination,TRUE,303);
		//header('Pragma: no-cache');
		//header('Cache-Control: no-cache, must-revalidate');

		$html = $this->generateRedirectPage($post);

		echo $html;
		flush();
		
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

	private function generateRedirectPage($post)
	{
		

		$html  = '<html>';
		$html .= '<head>
						<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
						<title>Redirecting</title>
				  </head>';
		$html .= '<body onload="document.getElementsByTagName(\'input\')[0].click();">';
		$html .= '<noscript>';
		$html .= '<p>Oops it looks like your browser does not support Javascript, if you would be so kind to click on the button below then we can proceed. ';
		$html .= '</p>';
		$html .= '</noscript>';
		$html .= '<form method="post" action="'.$this->destination.'">';
		$html .= '	<input type="submit" style="display:none"/>';
		foreach ($post as $key => $value) {
			$html .= '<input type="hidden" name="'.htmlspecialchars($key).'" value="'.htmlspecialchars($value).'"/> ';
		}
		$html .= '<noscript>';
		$html .= '	<input type="submit" value="Continue"/>';
		$html .= '</noscript>';
		$html .= '</form>'; 
		$html .= '</body>';
		$html .= '</html>';

		return $html;
	}
}