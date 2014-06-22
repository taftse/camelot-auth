<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 20/06/2014
 * Time: 12:55
 */

namespace T4s\CamelotAuth\Auth\Saml2\Bindings;

use T4s\CamelotAuth\Auth\Saml2\Core\Messages\AbstractMessage;
use T4s\CamelotAuth\Auth\Saml2\Core\Messages\RequestAbstractType;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

class HTTPRedirectBinding extends Binding
{
    protected $parematers = [ ];

    protected $signingCertificate = null;

    public function setRelayState($relayState)
    {
        $this->parematers['RelayState'] = $relayState;
    }


    public function getRelayState()
    {
        if(isset($this->parematers['RelayState']))
        {
            return $this->parematers['RelayState'];
        }

        return null;
    }

    public function setSigningCertificate($signingCertificate)
    {
        $this->signingCertificate = $signingCertificate;
    }

    public function send(AbstractMessage $message)
    {
        if(is_null($this->destination))
        {
            $this->destination = $message->getDestination();
        }

        $messageString = $message->toXML();
        $messageString = $message->getXMLMessage()->saveXML($messageString);

        $messageString = gzdeflate($messageString);
        $messageString = base64_encode($messageString);

        if($message instanceof RequestAbstractType)
        {
            $msg = 'SAMLRequest=';
        }
        else
        {
            $msg = 'SAMLResponse=';
        }

        $msg .= urlencode($messageString);
        $msg .= http_build_query($this->parematers);

        if($message->signRequest() && !is_null($this->signingCertificate))
        {
            $msg .= '&SigAlg='.urlencode($this->signingCertificate->type);
            $signature = $this->signingCertificate->sign($msg);
            $msg .= '&Signature='.urlencode(base64_encode($signature));
        }

        if(is_null($this->destination) || $this->destination == '' || preg_match("/\\s/",$this->destination))
        {
            throw new \Exception("No destination set for this request");
        }

        header('Location: '. $this->destination.'?'.$msg);
        header('Pragma: no-cache');
        header('Cache-Control: no-cache, must-revalidate');

        exit;
    }

    public function receive()
    {
        if(array_key_exists('SAMLResponse',$_GET))
        {
            $message = $_GET['SAMLResponse'];
        }
        else if(array_key_exists('SAMLRequest',$_GET))
        {
            $message = $_GET['SAMLRequest'];
        }
        else
        {
            throw new \Exception("Missing SAMLRequest or SAMLResponse parameter");
        }

        $encoding = Saml2Constants::Binding_Encoding_DEFLATE;
        if(array_key_exists('SAMLEncoding',$_GET))
        {
            $encoding = $_GET['SAMLEncoding'];
        }

        $message = base64_decode($message);

        switch($encoding)
        {
            case Saml2Constants::Binding_Encoding_DEFLATE:
                $message = gzinflate($message);
                break;
            default:
                throw new \Exception("Unknown SAMLEncoding");
                break;
        }

        return $message;
    }
} 