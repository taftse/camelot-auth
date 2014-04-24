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

class IDPSSODescriptor extends SSODescriptor implements SAMLNodeInterface
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

    public function __construct()
    {
        parent::__construct('IDPSSODescriptor');
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

    }
} 