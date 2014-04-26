<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Elements;


use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

class ContactPerson implements SAMLElementInterface
{
    protected $type;

    protected $extensions = null;

    protected $company = null;

    protected $givenName = null;

    protected $surName =null;

    /**
     * @var null|array
     */
    protected $emailAddress = null;

    /**
     * @var null|array
     */
    protected $telephoneNumber = null;

    public function __construct($type,$company = null,$givenName = null,$surName = null)
    {
        if($type instanceof \DOMElement)
        {
            return $this->importXML($type);
        }
        $this->type = $type;
        $this->company = $company;
        $this->givenName = $givenName;
        $this->surName = $surName;
    }

    public function toXML(\DOMElement $parentElement)
    {
        $contactPerson = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:ContactPerson');
        $parentElement->appendChild($contactPerson);

        $contactPerson->setAttribute('contactType',$this->type);

        if(!is_null($this->extensions))
        {
            $this->extensions->toXML($contactPerson);
        }

        if(!is_null($this->company))
        {
           $company =  $contactPerson->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:Company',$this->company);
           $contactPerson->appendChild($company);
        }

        if(!is_null($this->givenName))
        {
            $givenName =  $contactPerson->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:GivenName',$this->givenName);
            $contactPerson->appendChild($givenName);
        }

        if(!is_null($this->surName))
        {
            $surName =  $contactPerson->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:SurName',$this->surName);
            $contactPerson->appendChild($surName);
        }

        if(!is_null($this->emailAddress))
        {
            foreach($this->emailAddress as $email)
            {
                $emailAddress =  $contactPerson->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:EmailAddress',$email);
                $contactPerson->appendChild($emailAddress);
            }
        }

        if(!is_null($this->telephoneNumber))
        {
            foreach($this->telephoneNumber as $telephone)
            {
                $telNo =  $contactPerson->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:TelephoneNumber',$telephone);
                $contactPerson->appendChild($telNo);
            }
        }

        return $contactPerson;
    }

    public function importXML(\DOMElement $node)
    {
        if(!$node->hasAttribute('contactType'))
        {
            throw new \Exception("This ContactPerson is missing the required contactType attribute");
        }
        $this->type = $node->getAttribute('contactType');

        foreach($node->childNodes as $node)
        {
            switch($node->localName)
            {
                case "Extensions":
                    $this->extensions = $node;
                    break;
                case "Company":
                    $this->company = $node->nodeValue;
                    break;
                case "GivenName":
                    $this->givenName = $node->nodeValue;
                    break;
                case "SurName":
                    $this->surName = $node->nodeValue;
                    break;
                case "EmailAddress":
                    $this->emailAddress[] = $node->nodeValue;
                    break;
                case "TelephoneNumber":
                    $this->telephoneNumber[] = $node->nodeValue;
                    break;
            }
        }
    }
} 