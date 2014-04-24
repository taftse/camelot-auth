<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

class EntityDescriptor implements SAMLNodeInterface
{
    // attributes
    /**
     * @var
     */
    protected $entityID;

    /**
     * @var null
     */
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

    /**
     * @var null
     */
    protected  $signature = null;

    /**
     * @var null
     */
    protected $extensions = null;

    /**
     * @var array
     */
    protected $descriptors = array();

    /**
     * @var null
     */
    protected $organisation = null;

    /**
     * @var null|array
     */
    protected $contacts = null;

    /**
     * @var null|array
     */
    protected $aditionalMetadataLocations = null;

    public function __construct($entityId)
    {
        $this->entityID = $entityId;
    }

    public function toXML(\DOMElement $parentElement)
    {
        $entityDescriptor = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:EntityDescriptor');
        $parentElement->appendChild($entityDescriptor);

        $entityDescriptor->setAttribute('entityID',$this->entityID);

        if(!is_null($this->id))
        {
            $entityDescriptor->setAttribute('ID',$this->id);
        }

        if(!is_null($this->validUntil))
        {
            $entityDescriptor->setAttribute('validUntil',$this->validUntil);
        }

        if(!is_null($this->cacheDuration))
        {
            $entityDescriptor->setAttribute('cacheDuration',$this->cacheDuration);
        }

        if(!is_null($this->signature))
        {
            $this->signature->toXML($entityDescriptor);
        }

        if(!is_null($this->extensions))
        {
            $this->extensions->toXML($entityDescriptor);
        }

        foreach($this->descriptors as $descriptor)
        {
            $descriptor->toXML($entityDescriptor);
        }

        if(!is_null($this->organisation))
        {
            $this->organisation->toXML($entityDescriptor);
        }

        if(!is_null($this->contacts))
        {
            foreach($this->contacts as $contact)
            {
                $contact->toXML($entityDescriptor);
            }
        }

        if(!is_null($this->aditionalMetadataLocations))
        {
            foreach($this->aditionalMetadataLocations as $additionalMetadata)
            {
                $additionalMetadata->toXML($entityDescriptor);
            }
        }

        return $entityDescriptor;
    }

    public function addRoleDescriptor(RoleDescriptor $role)
    {
        $this->descriptors[] = $role;
    }

    public function  importXML(\DOMElement $node)
    {

    }
} 