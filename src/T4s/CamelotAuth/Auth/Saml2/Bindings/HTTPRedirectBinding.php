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
    protected $paramaters = [ ];

    protected $signingCertificate = null;

    public function setRelayState($relayState)
    {
        $this->paramaters['RelayState'] = $relayState;
    }


    public function getRelayState()
    {
        if(isset($this->paramaters['RelayState']))
        {
            return $this->paramaters['RelayState'];
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
        $msg .= '&'.http_build_query($this->paramaters);

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
        $get = $this->parseQueryString();

        if(array_key_exists('SAMLResponse',$get))
        {
            $message = $get['SAMLResponse'];
        }
        else if(array_key_exists('SAMLRequest',$get))
        {
            $message = $get['SAMLRequest'];
        }
        else
        {
            throw new \Exception("Missing SAMLRequest or SAMLResponse parameter");
        }

        $encoding = Saml2Constants::Binding_Encoding_DEFLATE;
        if(array_key_exists('SAMLEncoding',$get))
        {
            $encoding = $get['SAMLEncoding'];
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

        $document = new \DOMDocument();
        $document->loadXML($message);

        $message = AbstractMessage::getMessageFromXML($document->firstChild);

        if(array_key_exists('RelayState',$get))
        {
            $message->setRelayState($get['RelayState']);
        }

        if(array_key_exists('Signature',$get))
        {
            //@todo complete certificate validation
        }

        return $message;
    }


    protected function parseQueryString()
    {
        $return =[];
        $query ='';
        $relayState ='';
        $algarithm ='';
        foreach(explode('&',$_SERVER['QUERY_STRING']) as $get)
        {
            $temp = explode('=',$get,2);
            $name = $temp[0];
            $value = '';
            if(count($temp) ===2)
            {
                $value = $temp[1];
            }

            $name = urldecode($name);
            $return[$name] = urldecode($value);
            switch($name)
            {
                case 'SAMLRequest':
                case 'SAMLResponse':
                    $query = $name .'='.$value;
                    break;
                case 'RelayState':
                    $relayState = '&RelayState='.$value;
                    break;
                case 'SigAlg':
                    $algarithm = '&SigAlg='.$value;
                    break;
            }
        }

        $return['SignedQuery'] = $query.$relayState.$algarithm;

        return $return;
    }
}
