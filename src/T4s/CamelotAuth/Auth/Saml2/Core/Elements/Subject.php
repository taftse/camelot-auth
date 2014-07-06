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

class Subject implements SAMLElementInterface
{
    /**
     * @var null|BaseID|NameID|EncryptedID
     */
    protected $baseID = null;

    /**
     * @var null|array
     */
    protected $subjectConfirmation = null;

    public function addSubjectConfirmation(SubjectConfirmation $subjectConfirmation)
    {
        $this->subjectConfirmation[] = $subjectConfirmation;
    }

    public function  toXML(\DOMElement $parentElement)
    {
        $subject = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_SAML, 'saml:Subject');
        $parentElement->appendChild($subject);

        if(!is_null($this->baseID))
        {
            foreach($this->baseID as $baseID)
            {
                $baseID->toXML($subject);
            }
        }

        if(!is_null($this->subjectConfirmation))
        {
            foreach ($this->subjectConfirmation as $subjectConfirmation )
            {
                $subject->toXML($subject);
            }
        }

        return $subject;
    }

    public function importXML(\DOMElement $node)
    {
        throw new \Exception('unfinished function Subject->importXML()');
    }
} 