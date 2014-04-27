<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Elements;


class AffiliationDescriptor implements SAMLElementInterface
{
    protected $affiliationOwnerID;

    protected $id = null;

    /**
     * @var null
     */
    protected  $validUntil = null;
    /**
     * @var null
     */
    protected  $cacheDuration = null;

    // elements

    protected $signature = null;

    /**
     * @var null
     */
    protected $extensions = null;


    protected $affiliateMembers;

    /**
     * @var null|array
     */
    protected $keyDescriptors = null;

    public function __construct($affiliateOwnerID = null)
    {
        if($affiliateOwnerID instanceof \DOMElement)
        {
            return $this->importXML($affiliateOwnerID);
        }
        $this->affiliationOwnerID = $affiliateOwnerID;
    }

    public function toXML(\DOMElement $parentElement)
    {
        $descriptor = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:AffiliationDescriptorType');
        $parentElement->appendChild($descriptor);

        $descriptor->setAttribute('affiliationOwnerID',$this->affiliationOwnerID);

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

        if(!is_null($this->signature))
        {
            $this->signature->toXML($descriptor);
        }

        if(!is_null($this->extensions))
        {
            $this->extensions->toXML($descriptor);
        }

        foreach($this->affiliateMembers as $affiliateMembers)
        {
            $affiliateMembers->toXML($descriptor);
        }

        if(!is_null($this->keyDescriptors))
        {
            foreach($this->keyDescriptors as $key)
            {
                $key->toXML($descriptor);
            }
        }

        return $descriptor;
    }

    public function importXML(\DOMElement $node)
    {
        if(!$node->hasAttribute('affiliationOwnerID'))
        {
            throw new \Exception("This AffiliationDescriptor is missing the required affiliationOwnerID attribute");
        }
        $this->affiliationOwnerID = $node->getAttribute('affiliationOwnerID');

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
                case "AffiliateMember":
                    $this->affiliateMembers[] = $node->nodeValue;
                    break;
                case "KeyDescriptor":
                    $this->keyDescriptors[] = new KeyDescriptor($node);
                    break;
            }
        }
    }
} 