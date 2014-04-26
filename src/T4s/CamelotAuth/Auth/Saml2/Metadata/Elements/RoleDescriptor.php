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

abstract class RoleDescriptor implements SAMLElementInterface
{
    protected $descriptorType;


    protected $id = null;

    /**
     * @var null
     */
    protected  $validUntil = null;
    /**
     * @var null
     */
    protected  $cacheDuration = null;


    protected  $protocolSupportEnumeration;

    protected $errorURL = null;

    // elements

    protected $signature = null;

    /**
     * @var null
     */
    protected $extensions = null;

    /**
     * @var null|array
     */
    protected $keyDescriptors = null;

    protected  $organization = null;

    protected $contacts = null;


    public function __construct($descriptorType,$protocolSupportEnumeration = null)
    {
        if(is_null($protocolSupportEnumeration))
        {
            $protocolSupportEnumeration = Saml2Constants::Namespace_SAMLProtocol;
        }
        $this->protocolSupportEnumeration = $protocolSupportEnumeration;
        $this->descriptorType = $descriptorType;
    }

    public function toXML(\DOMElement $parentElement)
    {
        $descriptor = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:'.$this->descriptorType);
        $parentElement->appendChild($descriptor);

        $descriptor->setAttribute('protocolSupportEnumeration',$this->protocolSupportEnumeration);

        if(!is_null($this->id))
        {
            $descriptor->setAttribute('ID',$this->id);
        }

        if(!is_null($this->validUntil))
        {
            $descriptor->setAttribute('validUntil',$this->validUntil);
        }

        if(!is_null($this->cacheDuration))
        {
            $descriptor->setAttribute('cacheDuration',$this->cacheDuration);
        }

        if(!is_null($this->errorURL))
        {
            $descriptor->setAttribute('errorURL',$this->errorURL);
        }

        if(!is_null($this->signature))
        {
            $this->signature->toXML($descriptor);
        }

        if(!is_null($this->extensions))
        {
            $this->extensions->toXML($descriptor);
        }

        if(!is_null($this->keyDescriptors))
        {
            foreach($this->keyDescriptors as $key)
            {
                $key->toXML($descriptor);
            }
        }

        if(!is_null($this->organization))
        {
            $this->organization->toXML($descriptor);
        }

        if(!is_null($this->contacts))
        {
            foreach($this->contacts as $contact)
            {
                $contact->toXML($descriptor);
            }
        }

        return $descriptor;
    }

    public function importXML(\DOMElement $node)
    {
        if($node->hasAttribute('ID'))
        {
            $this->id = $node->getAttribute('ID');
        }

        if($node->hasAttribute('validUntil'))
        {
            $this->validUntil = $node->getAttribute('validUntil');
        }

        if($node->hasAttribute('cacheDuration'))
        {
            $this->cacheDuration = $node->getAttribute('cacheDuration');
        }

        if(!$node->hasAttribute('protocolSupportEnumeration'))
        {
            throw new \Exception("This ".$this->descriptorType." is missing the required protocolSupportEnumeration attribute");
        }
        $this->protocolSupportEnumeration = $node->getAttribute('protocolSupportEnumeration');

        if($node->hasAttribute('errorURL'))
        {
            $this->errorURL = $node->getAttribute('errorURL');
        }

        foreach($node->childNodes as $node)
        {
            switch($node->localName)
            {
                case "Signature":
                    $this->signature = $node;
                    break;
                case "Extensions":
                    $this->extensions = $node;
                    break;
                case "KeyDescriptor":
                    $this->keyDescriptors[] = new KeyDescriptor($node);
                    break;
                case "Organization":
                    $this->organisation = new Organization($node);
                    break;
                case "ContactPerson":
                    $this->contacts[] = new ContactPerson($node);
                    break;
            }
        }
    }

} 