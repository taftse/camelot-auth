<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Elements;


use T4s\CamelotAuth\Auth\Saml2\Exceptions\UnknownAttributeException;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

class EntityDescriptor implements SAMLElementInterface
{
    // attributes

    protected $attributes = [];

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
        else if(is_array($entityId))
        {

            return $this->importArray($entityId);
        }
        $this->attributes['entityID'] = $entityId;
    }

    public function getEntityID()
    {
        return $this->attributes['entityID'];
    }

    public function descriptorExists($descriptorType)
    {
        return array_key_exists($descriptorType,$this->descriptors);
    }

    public function getDescriptor($descriptorType)
    {
        if(!$this->descriptorExists($descriptorType))
        {
            throw new \Exception("This Entity does not have a descriptor type of ". $descriptorType);
        }
        return $this->descriptors[$descriptorType];
    }

    public function getAttribute($attribute,$default = null)
    {
        if(isset($this->attributes[$attribute]))
        {
            return $this->attributes[$attribute];
        }
        if(is_null($default))
        {
            throw new UnknownAttributeException($attribute);
        }
        return $default;
    }

    public function getValidatedValue($attributeName,$validOptions,$default)
    {
        $returnedAttribute = $this->getAttribute($attributeName,$default);

        if($returnedAttribute === $default)
        {
            return $returnedAttribute;
        }

        if(!in_array($returnedAttribute, $validOptions))
        {
            throw new \Exception("The ".$attributeName." attribute returned an value (".$returnedAttribute.") which is not contained in the array of valid options");
        }

        return $returnedAttribute;
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

    public function getEndpoints($endpointType)
    {
        $endpoints = [];
        foreach($this->getServices() as $endpoint)
        {

            if(isset($endpoint[$endpointType]))
            {
                $endpoints[] = $endpoint[$endpointType];
            }
        }

        return $endpoints;
    }


    public function getDefaultEndpoint($endpointType,$allowedEndpointBinding = null,$default = null)
    {
        $endpoints = $this->getEndpoints($endpointType);
        $firstAllowed = null;
        $firstNotFalse = null;


        foreach ($endpoints as $endpoint) {
            if(!is_null($allowedEndpointBinding) && !in_array($endpoint->getBinding(),$allowedEndpointBinding))
            {
                continue;
            }

            if($endpoint instanceof IndexedEndpointType)
            {
                if($endpoint->isDefault())
                {
                    return $endpoint;
                }

                if(is_null($firstAllowed))
                {
                    $firstAllowed = $endpoint;
                }
            }
            else if(is_null($firstNotFalse))
            {
                $firstNotFalse = $endpoint;
            }
        }

        if(!is_null($firstNotFalse))
        {
            return $firstNotFalse;
        }
        else if(!is_null($firstAllowed))
        {
            return $firstAllowed;
        }

    }


    public function getCertificates()
    {
        $certificates = [];
        foreach($this->descriptors  as $descriptor)
        {
            if(is_null($descriptor->getCertificates()))
            {
                continue;
            }
            $certificates = array_merge($descriptor->getCertificates(),$certificates);
        }

        return $certificates;
    }

    public function getContacts()
    {
        return $this->contacts;
    }

    public function addRoleDescriptor(RoleDescriptor $role)
    {
        $this->descriptors[] = $role;
    }

    public function toXML(\DOMElement $parentElement)
    {
        $entityDescriptor = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:EntityDescriptor');
        $parentElement->appendChild($entityDescriptor);

        $entityDescriptor->setAttribute('entityID',$this->attributes['entityID']);

        if(!is_null($this->id))
        {
            $entityDescriptor->setAttribute('ID',$this->attributes['id']);
        }

        if(!is_null($this->validUntil))
        {
            $entityDescriptor->setAttribute('validUntil',$this->attributes['validUntil']);
        }

        if(!is_null($this->cacheDuration))
        {
            $entityDescriptor->setAttribute('cacheDuration',$this->attributes['cacheDuration']);
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
        $this->attributes['entityID'] = $node->getAttribute('entityID');

        if($node->hasAttribute('ID'))
        {
            $this->attributes['id'] = $node->getAttribute('ID');
        }

        if($node->hasAttribute('validUntil'))
        {
            $this->attributes['validUntil'] = $node->getAttribute('validUntil');
        }

        if($node->hasAttribute('cacheDuration'))
        {
            $this->attributes['cacheDuration'] = $node->getAttribute('cacheDuration');
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

    public function importArray(array $configArray)
    {
        if(!isset($configArray['entityid']))
        {
            throw new \Exception("This EntiryDescriptor is missing the required entityID attribute");
        }
        $this->attributes['entityID'] = $configArray['entityid'];

        if(isset($configArray['id']))
        {
            $this->attributes['id'] = $configArray['id'];
        }

        if(isset($configArray['validuntil']))
        {
            $this->attributes['validUntil'] = $configArray['validuntil'];
        }

        if(isset($configArray['cacheduration']))
        {
            $this->attributes['cacheDuration'] = $configArray['cacheduration'];
        }

        foreach($configArray as $key=>$value)
        {
            switch($key)
            {
                case "Signature":
                    $this->signature = $value;
                    break;
                case "Extensions":
                    $this->extensions = $value;
                    break;
                case "IDPSSODescriptor":
                    $this->descriptors[] = new IDPSSODescriptor($value);
                    break;
                case "SPSSODescriptor":
                    $this->descriptors[] = new SPSSODescriptor($value);
                    break;
                case "AuthnAuthorityDescriptor":
                    $this->descriptors[] = new AuthnAuthorityDescriptor($value);
                    break;
                case "AttributeAuthorityDescriptor":
                    $this->descriptors[] = new AttributeAuthorityDescriptor($value);
                    break;
                case "PDPDescriptor":
                    $this->descriptors[] = new PDPDescriptor($value);
                    break;
                case "AffiliationDescriptor":
                    $this->descriptors[] = new AffiliationDescriptor($value);
                    break;
                case "Organization":
                    $this->organization = new Organization($value);
                    break;
                case "ContactPerson":
                    $this->contacts[] = new ContactPerson($value);
                    break;
                case "AdditionalMetadataLocation":
                    $this->aditionalMetadataLocations[] = new AdditionalMetadataLocation($value);
                    // perfect location for a event me thinks
                    break;
            }
        }

    }
} 