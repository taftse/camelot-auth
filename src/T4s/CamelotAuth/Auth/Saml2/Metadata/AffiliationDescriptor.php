<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


class AffiliationDescriptor implements SAMLNodeInterface
{
    protected $affiliateOwnerID;

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
        $this->affiliateOwnerID = $affiliateOwnerID;
    }

    public function toXML(\DOMElement $parentElement)
    {
        $descriptor = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:AffiliationDescriptorType');
        $parentElement->appendChild($descriptor);

        $descriptor->setAttribute('affiliationOwnerID',$this->affiliateOwnerID);

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
} 