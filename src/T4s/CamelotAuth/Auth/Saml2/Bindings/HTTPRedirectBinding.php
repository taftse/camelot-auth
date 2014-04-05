<?php namespace T4s\CamelotAuth\Auth\Saml2\bindings;

use T4s\CamelotAuth\Auth\Saml2\Messages\AbstractMessage;
use T4s\CamelotAuth\Auth\Saml2\bindings\Binding;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;
/**
* 
*/
class HTTPRedirectBinding extends Binding
{
	protected $get = array();
	protected $parameters = array();

	/**
	 * The certificate used to sign the request
	 *
	 * @var string
	 */

	protected $signingCertificate = null;


	public function setRelayState($relayState)
	{
		$this->parameters['RelayState'] = $relayState;
	}

	public function getRelayState()
	{
		if(isset($this->parameters['RelayState']))
		{
			return $this->parameters['RelayState'];
		}
		return null;
	}

	/**
	 * sets the certificate that should be used to sign the request
	 *
	 *
	 */
	public function setSigningCertificate($certificate)
	{
		$this->signingCertificate = $certificate;
	}




	public function send(AbstractMessage $message)
	{

		if(is_null($this->destination))
		{
			$this->destination = $message->getDestination();
		}

		$messageString = $message->generateUnsignedMessage();
		$messageString = $message->getXMLMessage()->saveXML($messageString);

		$messageString = gzdeflate($messageString);
		$messageString = base64_encode($messageString);

		if($message instanceof RequestMessage)
		{
			$msg = 'SAMLRequest=';
		}else{
			$msg = 'SAMLResponse=';
		}
		$msg .=urlencode($messageString);
		
		$msg .= http_build_query($this->parameters);

		if($message->signRequest() && !is_null($this->signingCertificate))
		{
			$msg .= '&SigAlg='.urlencode($this->signingCertificate->type);
			$signature = $this->signingCertificate->sign($msg);
			$msg .= '&Signature='.urlencode(base64_encode($Signature));
		}

		if(is_null($this->destination) || $this->destination == '' ||  preg_match("/\\s/", $this->destination))
		{
			throw new \Exception("No destination set for this Request");
			
		}

		header('Location: ' . $this->destination.'?'.$msg);
		header('Pragma: no-cache');
		header('Cache-Control: no-cache, must-revalidate');
        exit;
	}

	public function receive()
	{
		$this->parseQueryString();

		if(array_key_exists('SAMLResponse', $this->get))
		{
			$message = $this->get['SAMLResponse'];
		}
		else if(array_key_exists('SAMLRequest', $this->get))
		{
			$message = $this->get['SAMLRequest'];
		}
		else
		{
			throw new \Exception("missing SAMLRequest or SAMLResponse parameter");
		}

		$encoding = Saml2Constants::Binding_Encoding_DEFLATE;
		if(array_key_exists('SAMLEncoding',$this->get))
		{
			$encoding = $this->get['SAMLEncoding'];
		}

		$message = base64_decode($message);
		switch ($encoding) {
			case Saml2Constants::Binding_Encoding_DEFLATE:
				$message = gzinflate($message);
				break;
			
			default:
				throw new \Exception("Unknown SAMLEncoding");
				
				break;
		}

		$XMLMessage = new \DOMDocument();
		$XMLMessage->loadXML($message);
		$message = AbstractMessage::getMessageFromXML($XMLMessage->firstChild);
		

		if(array_key_exists('RelayState', $this->get))
		{
			$message->setRelayState(''.$this->get['RelayState']);
		}

		if(array_key_exists('Signature',$this->get))
		{
			if(!array_key_exists('SigAlg',$this->get))
			{
				throw new Exception("missing signature algorithm");
			}

			$signatureData = ['Signature' => $this->get['Signature'],
							  'SigAlg' => $this->get['SigAlg'],
							  'Query'=>$this->get['SignedQuery']
							 ];

			//$message->addValidator(array())
		}

		return $message;
	}

	/*
	adapted from the SIMPLE SAML PHP LIBRARY
	*/
	protected function parseQueryString()
	{
		$relayState = '';
		$sigAlg = '';

		foreach(explode('&',$_SERVER['QUERY_STRING']) as $e){
			list($key,$value) = explode('=',$e,2);
			$key = urldecode($key);
			$value = urldecode($value);
			$this->get[$key] = $value;

			switch ($key) {
				case 'SAMLRequest':
				case 'SAMLResponse':
					$signatureQuery = $key . '=' . $value;
					break;
				case 'RelayState':
					$relayState = '&RelayState='.$value;
					break;
				case 'SigAlg':
					$sigAlg = '&SigAlg='.$value;
					break;
			}
		}

		$this->get['SignedQuery']= $sigAlg.$relayState.$sigAlg;

		return $this->get;
	}
	
}