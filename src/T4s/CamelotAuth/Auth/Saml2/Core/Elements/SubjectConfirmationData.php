<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Core\Elements;


use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\SAMLElementInterface;

class SubjectConfirmationData implements  SAMLElementInterface
{

        /**
         * attributes
         */

    protected $notBefore = null;

    protected $notOnOrAfter = null;

    protected $recipient = null;

    protected $inResponseTo = null;

    protected $address = null;

    public function setNotOnOrAfter($notOnOrAfter)
    {
        $this->notOnOrAfter = $notOnOrAfter;
    }

    public function setInResponseTo($inResponseTo)
    {
        $this->inResponseTo = $inResponseTo;
    }

    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    public function  toXML(\DOMElement $parentElement)
    {
        $subjectConfirmationData = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_SAML,'saml:SubjectConfirmationData');
        $parentElement->appendChild($subjectConfirmationData);

        if(!is_null($this->notBefore))
        {
            $subjectConfirmationData->setAttribute('NotBefore',date('Y-m-d\TH:i:s\Z',$this->notBefore));
        }

        if(!is_null($this->notOnOrAfter))
        {
            $subjectConfirmationData->setAttribute('NotOnOrAfter',date('Y-m-d\TH:i:s\Z',$this->notOnOrAfter));
        }

        if(!is_null($this->recipient))
        {
            $subjectConfirmationData->setAttribute('Recipient',$this->recipient);
        }

        if(!is_null($this->inResponseTo))
        {
            $subjectConfirmationData->setAttribute('InResponseTo',$this->inResponseTo);
        }

        if(!is_null($this->address))
        {
            $subjectConfirmationData->setAttribute('Address',$this->address);
        }

        return $subjectConfirmationData;

    }

    public function importXML(\DOMElement $node)
    {
        throw new \Exception('unfinished function SubjectConfirmationData->importXML()');
    }

} 