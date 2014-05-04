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

class EntityDescriptor implements SAMLElementInterface
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
    protected $organization = null;

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
        if($entityId instanceof \DOMElement)
        {
            return $this->importXML($entityId);
        }
        $this->entityID = $entityId;
    }

    public function getEntityID()
    {
        return $this->entityID;
    }

    public function getServices()
    {
        $services = [];

        foreach($this->descriptors as $descriptor)
        {
            $services = array_merge($descriptor->getServices(),$services);
        }

        return $services;
    }

    public function addRoleDescriptor(RoleDescriptor $role)
    {
        $this->descriptors[] = $role;
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

        if(!is_null($this->organization))
        {
            $this->organization->toXML($entityDescriptor);
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



    public function  importXML(\DOMElement $node)
    {
        if(!$node->hasAttribute('entityID'))
        {
            throw new \Exception("This EntiryDescriptor is missing the required entityID attribute");
        }
        $this->entityID = $node->getAttribute('entityID');

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
                case "IDPSSODescriptor":
                    $this->descriptors[] = new IDPSSODescriptor($node);
                    break;
                case "SPSSODescriptor":
                    $this->descriptors[] = new SPSSODescriptor($node);
                    break;
                case "AuthnAuthorityDescriptor":
                    $this->descriptors[] = new AuthnAuthorityDescriptor($node);
                    break;
                case "AttributeAuthorityDescriptor":
                    $this->descriptors[] = new AttributeAuthorityDescriptor($node);
                    break;
                case "PDPDescriptor":
                    $this->descriptors[] = new PDPDescriptor($node);
                    break;
                case "AffiliationDescriptor":
                    $this->descriptors[] = new AffiliationDescriptor($node);
                    break;
                case "Organization":
                    $this->organization = new Organization($node);
                    break;
                case "ContactPerson":
                    $this->contacts[] = new ContactPerson($node);
                    break;
                case "AdditionalMetadataLocation":
                    $this->aditionalMetadataLocations[] = new AdditionalMetadataLocation($node);
                    // perfect location for a event me thinks
                    break;
            }
        }
    }
} 