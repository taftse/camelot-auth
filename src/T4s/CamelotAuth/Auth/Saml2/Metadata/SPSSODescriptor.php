<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


class SPSSODescriptor extends SSODescriptor implements SAMLNodeInterface
{

    protected $authnRequestsSigned = false;

    protected $wantAssertionSigned = false;

    protected $assertionConsumingService = array();

    /**
     * @var null|array
     */
    protected $attributeConsumingService = null;

    public function __construct()
    {
        parent::__construct('SPSSODescriptor');
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

        foreach($this->assertionConsumingService as $acs)
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

        $this->assertionConsumingService[] = $index;
    }
} 