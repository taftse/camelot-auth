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

    public function __construct($metadataNode= null )
    {
        parent::__construct('SPSSODescriptor');

        if($metadataNode instanceof \DOMElement)
        {
            return $this->importXML($metadataNode);
        }
        else if(is_array($metadataNode))
        {
            return $this->importArray($metadataNode);
        }
    }

    public function getServices()
    {
        $services = parent::getServices();

        foreach($this->assertionConsumerService as $acs)
        {
            $services[]['AssertionConsumerService'] = $acs;
        }

        if(!is_null($this->attributeConsumingService))
        {
            foreach($this->attributeConsumingService as $acs)
            {
                $services[]['AttributeConsumingService'] = $acs;
            }
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

    public function addAssertionConsumerService($index,$binding= null,$location = null,$responseLocation= null)
    {
        if(!$index instanceof EndpointType)
        {
            $index = new IndexedEndpointType($index,$binding,$location,$responseLocation);
        }

        $this->assertionConsumerService[] = $index;
    }

    public function addAttributeConsumingService(AttributeConsumingService $acs)
    {
        $this->attributeConsumingService[] = $acs;
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

    public function importArray(array $array)
    {
        parent::importArray($array);

        if(isset($array['AuthnRequestsSigned']))
        {
            $this->authnRequestsSigned = $array['AuthnRequestsSigned'];
        }

        if(isset($array['WantAssertionSigned']))
        {
            $this->wantAssertionSigned = $array['WantAssertionSigned'];
        }

        foreach($array as $key=>$value)
        {

            switch($key)
            {
                case "AssertionConsumerService":
                    foreach($value as $type=> $endpoint) {
                        $this->assertionConsumerService[] = new IndexedEndpointType($endpoint);
                    }
                    break;
                case "AttributeConsumingService":
                    $this->attributeConsumingService[] = new AttributeConsumingService($value);
                    break;
            }
        }

    }
} 