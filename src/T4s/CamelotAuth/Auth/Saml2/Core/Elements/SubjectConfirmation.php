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
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

class SubjectConfirmation implements SAMLElementInterface
{
    /**
     * attribute
     */

    protected $method;


    /**
     * elements
     */

    /**
     * @var null|BaseIDType|NameID|EncryptedID
     */
    protected $baseID = null;

    /**
     * @var null|array
     */
    protected $subjectConfirmationData = null;

    public function setSubjectConfirmationData(SubjectConfirmationData $subjectConfirmationData)
    {
        $this->subjectConfirmationData[] = $subjectConfirmationData;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function  toXML(\DOMElement $parentElement)
    {
        $subjectConfirmation = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_SAML,'saml:SubjectConfirmation');
        $parentElement->appendChild($subjectConfirmation);

        $subjectConfirmation->setAttribute('Method',$this->method);

        if(!is_null($this->subjectConfirmationData))
        {
            foreach ($this->subjectConfirmationData as $subjectConfirmationData )
            {
                $subjectConfirmationData->toXML($subjectConfirmation);
            }
        }

        if(!is_null($this->baseID))
        {
            foreach($this->baseID as $baseID)
            {
                $baseID->toXML($subjectConfirmation);
            }
        }
    }

    public function importXML(\DOMElement $node)
    {
        throw new \Exception('unfinished function SubjectConfirmation->importXML()');
    }

} 