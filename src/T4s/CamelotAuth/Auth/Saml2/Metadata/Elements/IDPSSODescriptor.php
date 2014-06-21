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

class IDPSSODescriptor extends SSODescriptor implements SAMLElementInterface
{
    protected $wantAuthnRequestSigned = false;

    /**
     * @var array
     */
    protected $singleSignOnService = array();

    /**
     * @var null|array
     */
    protected $nameIDMappingService = null;

    /**
     * @var null|array
     */
    protected $assertionIDRequestService = null;

    /**
     * @var null|array
     */
    protected $attributeProfile = null;

    /**
     * @var null|array
     */
    protected $attributes = null;

    public function __construct($metadatNode = null)
    {
        parent::__construct('IDPSSODescriptor');

        if($metadatNode instanceof \DOMElement)
        {
            return $this->importXML($metadatNode);
        }
        else if(is_array($metadatNode))
        {

            return $this->importArray($metadatNode);
        }
    }

    public function getServices()
    {
        $services = parent::getServices();

        foreach($this->singleSignOnService as $ssos)
        {
            $services[]['SingleSignOnService'] = $ssos;
        }
        return $services;
    }

    public function toXML(\DOMElement $parentElement)
    {
        $descriptor = parent::toXML($parentElement);

        if($this->wantAuthnRequestSigned == true)
        {
            $descriptor->setAttribute('wantAuthnRequestSigned','true');
        }

        foreach($this->singleSignOnService as $SSO)
        {
            $endpoint = $descriptor->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:SingleSignOnService');
            $descriptor->appendChild($endpoint);

            $SSO->toXML($endpoint);
        }

        if(!is_null($this->nameIDMappingService))
        {
            foreach($this->nameIDMappingService as $nidms)
            {
                $endpoint = $descriptor->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:NameIDMappingService');
                $descriptor->appendChild($endpoint);

                $nidms->toXML($endpoint);
            }
        }

        if(!is_null($this->assertionIDRequestService))
        {
            foreach($this->assertionIDRequestService as $aidrs)
            {
                $endpoint = $descriptor->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:AssertionIDRequestService');
                $descriptor->appendChild($endpoint);

                $aidrs->toXML($endpoint);
            }
        }

        if(!is_null($this->attributeProfile))
        {
            foreach($this->attributeProfile as $attribute)
            {
                $attributeProfile = $descriptor->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:AttributeProfile',$attribute);
                $descriptor->appendChild($attributeProfile);
            }
        }

        if(!is_null($this->attributes))
        {
            foreach($this->attributes as $attribute)
            {
                $attributeNode = $descriptor->ownerDocument->createElementNS(Saml2Constants::Namespace_SAML,'saml:Attribute',$attribute);
                $descriptor->appendChild($attributeNode);
            }
        }

        return $descriptor;

    }

    public function addSingleSignOnService($binding,$location = null,$responseLocation= null)
    {
        if(!$binding instanceof EndpointType)
        {
            $binding = new EndpointType($binding,$location,$responseLocation);
        }

        $this->singleSignOnService[] = $binding;
    }

    public function addNameIDMappingService($binding,$location = null,$responseLocation= null)
    {
        if(!$binding instanceof EndpointType)
        {
            $binding = new EndpointType($binding,$location,$responseLocation);
        }

        $this->nameIDMappingService[] = $binding;
    }

    public function addAssertionIDRequestService($binding,$location = null,$responseLocation= null)
    {
        if(!$binding instanceof EndpointType)
        {
            $binding = new EndpointType($binding,$location,$responseLocation);
        }

        $this->assertionIDRequestService[] = $binding;
    }



    public function importXML(\DOMElement $node)
    {
        parent::importXML($node);

        if($node->hasAttribute('WantAuthnRequestSigned'))
        {
            $this->wantAuthnRequestSigned = $node->getAttribute('WantAuthnRequestSigned');
        }

        foreach($node->childNodes as $node)
        {
            switch($node->localName)
            {
                case "SingleSignOnService":
                    $this->singleSignOnService[] = new EndpointType($node);
                    break;
                case "NameIDMappingService":
                    $this->nameIDMappingService[] = new EndpointType($node);
                    break;
                case "AssertionIDRequestService":
                    $this->assertionIDRequestService[] = new EndpointType($node);
                    break;
                case "AttributeProfile":
                    $this->attributeProfile[] = $node->nodeValue;
                    break;
                case "Attribute":
                    // @todo create Attribute Elemnt
                    //$this->attributes[] = new Attribute;
                    break;
            }
        }
    }

    public function importArray(array $array)
    {
        parent::importArray($array);

        if(isset($array['WantAuthnRequestSigned']))
        {
            $this->wantAuthnRequestSigned = $array['WantAuthnRequestSigned'];
        }

        foreach($array as $key=>$value)
        {

            switch($key)
            {
                case "SingleSignOnService":
                    foreach($value as $type=> $endpoint)
                    {
                        $this->singleSignOnService[] = new EndpointType($endpoint);
                    }
                    break;
                case "NameIDMappingService":
                    foreach($value as $type=> $endpoint)
                    {
                        $this->nameIDMappingService[] = new EndpointType($endpoint);
                    }
                    break;
                case "AssertionIDRequestService":
                    foreach($value as $type=> $endpoint)
                    {
                        $this->assertionIDRequestService[] = new EndpointType($endpoint);
                    }
                    break;
                case "AttributeProfile":
                    $this->attributeProfile[] = $value;
                    break;
                case "Attribute":
                    // @todo create Attribute Elemnt
                    //$this->attributes[] = new Attribute;
                    break;
            }
        }

    }
} 