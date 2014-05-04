<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Elements;


class SPSSODescriptor extends SSODescriptor implements SAMLElementInterface
{

    protected $authnRequestsSigned = false;

    protected $wantAssertionSigned = false;

    protected $assertionConsumerService = array();

    /**
     * @var null|array
     */
    protected $attributeConsumingService = null;

    public function __construct(\DOMElement $metadatNode= null )
    {
        parent::__construct('SPSSODescriptor');

        if(!is_null($metadatNode))
        {
            return $this->importXML($metadatNode);
        }
    }

    public function getServices()
    {
        $services = parent::getServices();

        foreach($this->assertionConsumerService as $acs)
        {
            $services[]['AssertionConsumerService'] = $acs;
        }

        return $services;
    }

    public function toXML(\DOMElement $parentElement)
    {
        $descriptor = parent::toXML($parentElement);

        if($this->authnRequestsSigned == true)
        {
            $descriptor->setAttribute('AuthnRequestsSigned','true');
        }

        if($this->wantAssertionSigned == true)
        {
            $descriptor->setAttribute('WantAssertionSigned','true');
        }

        foreach($this->assertionConsumerService as $acs)
        {
            $acs->toXML($descriptor);
        }

        if(!is_null($this->attributeConsumingService))
        {
            foreach($this->attributeConsumingService as $acs)
            {
                $acs->toXML($descriptor);
            }
        }

        return $descriptor;
    }

    public function addAssertionConsumingService($index,$binding= null,$location = null,$responseLocation= null)
    {
        if(!$index instanceof EndpointType)
        {
            $index = new IndexedEndpointType($index,$binding,$location,$responseLocation);
        }

        $this->assertionConsumerService[] = $index;
    }

    public function importXML(\DOMElement $node)
    {
        parent::importXML($node);

        if($node->hasAttribute('AuthnRequestsSigned'))
        {
            $this->authnRequestsSigned = $node->getAttribute('AuthnRequestsSigned');
        }

        if($node->hasAttribute('WantAssertionSigned'))
        {
            $this->wantAssertionSigned = $node->getAttribute('WantAssertionSigned');
        }

        foreach($node->childNodes as $node)
        {
            switch($node->localName)
            {
                case "AssertionConsumerService":
                    $this->assertionConsumerService[] = new IndexedEndpointType($node);
                    break;
                case "AttributeConsumingService":
                    $this->attributeConsumingService[] = new AttributeConsumingService($node);
                    break;
            }
        }
    }
} 