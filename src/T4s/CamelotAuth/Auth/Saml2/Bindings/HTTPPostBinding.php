<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 20/06/2014
 * Time: 13:00
 */

namespace T4s\CamelotAuth\Auth\Saml2\Bindings;


use T4s\CamelotAuth\Auth\Saml2\Core\Messages\AbstractMessage;

class HTTPPostBinding extends Binding
{

    public function send(AbstractMessage $message)
    {
        if(is_null($this->destination))
        {
            $this->destination = $message->getDestination();
        }


    }

    public function receive()
    {
        if(array_key_exists('SAMLResponse',$_POST))
        {
            $message = $_POST['SAMLResponse'];
        }
        else if(array_key_exists('SAMLRequest',$_POST))
        {
            $message = $_GET['SAMLRequest'];
        }
        else
        {
            throw new \Exception("Missing SAMLRequest or SAMLResponse parameter");
        }

        $message = base64_decode($message);

        $document = new \DOMDocument();
        $document->loadXML($message);

        $message = AbstractMessage::getMessageFromXML($document->firstChild);

        if(array_key_exists('RelayState',$_POST))
        {
            $message->setRelayState($_POST['RelayState']);
        }
        return $message;
    }
} 